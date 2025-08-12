<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExpensePerson;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WhatsappSession;
use App\Services\OpenRouterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class WhatsAppController extends Controller
{
    protected OpenRouterService $openRouterService;

    // Rate limiting constants
    private const RATE_LIMIT_ATTEMPTS = 5;
    private const RATE_LIMIT_MINUTES = 15;
    private const SESSION_TIMEOUT_MINUTES = 30;

    public function __construct(OpenRouterService $openRouterService)
    {
        // Remove auth:sanctum middleware - use WhatsApp session identification instead
        $this->openRouterService = $openRouterService;
        
        // Validate configurations on instantiation
        $this->validateConfigurations();
    }

    /**
     * Validate required configurations
     */
    protected function validateConfigurations(): void
    {
        // Validate OpenRouter configuration
        $openRouterKey = config('services.openrouter.key');
        if (empty($openRouterKey)) {
            Log::warning('OpenRouter API key not configured');
        }

        // Validate WhatsApp configuration for webhook methods
        $whatsappConfig = [
            'api_url' => config('services.whatsapp.api_url'),
            'api_token' => config('services.whatsapp.api_token'),
            'phone_number_id' => config('services.whatsapp.phone_number_id'),
            'webhook_token' => config('services.whatsapp.webhook_token'),
        ];

        $missingConfigs = [];
        foreach ($whatsappConfig as $key => $value) {
            if (empty($value)) {
                $missingConfigs[] = $key;
            }
        }

        if (!empty($missingConfigs)) {
            Log::warning('WhatsApp configuration incomplete', [
                'missing_configs' => $missingConfigs
            ]);
        }
    }

    /**
     * Get user from WhatsApp session or number
     */
    protected function getUserFromRequest(Request $request): ?User
    {
        // Priority 1: Get from WhatsApp session ID
        if ($request->has('session_id')) {
            $session = WhatsappSession::find($request->session_id);
            if ($session) {
                return User::where('whatsapp_number', $session->whatsapp_number)
                    ->where('whatsapp_status', 'verified')
                    ->first();
            }
        }

        // Priority 2: Get from WhatsApp number directly
        if ($request->has('whatsapp_number')) {
            return User::where('whatsapp_number', $request->whatsapp_number)
                ->where('whatsapp_status', 'verified')
                ->first();
        }

        // Priority 3: Fallback to user_id for backward compatibility
        if ($request->has('user_id')) {
            return User::find($request->user_id);
        }

        return null;
    }

    /**
     * Get or create WhatsApp session for a phone number
     */
    protected function getOrCreateSessionFromRequest(Request $request): ?WhatsappSession
    {
        if ($request->has('session_id')) {
            return WhatsappSession::find($request->session_id);
        }

        if ($request->has('whatsapp_number')) {
            return $this->getOrCreateSession($request->whatsapp_number);
        }

        return null;
    }

    /**
     * Validate user is authenticated via WhatsApp
     */
    protected function validateWhatsAppUser(Request $request): array
    {
        $user = $this->getUserFromRequest($request);
        
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found or not authenticated via WhatsApp',
                'code' => 401
            ];
        }

        if ($user->whatsapp_status !== 'verified') {
            return [
                'success' => false,
                'message' => 'WhatsApp account not verified',
                'code' => 403
            ];
        }

        return [
            'success' => true,
            'user' => $user
        ];
    }

    /**
     * Parse expense message from WhatsApp or manual input
     */
    public function parseExpense(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
            'whatsapp_number' => 'sometimes|string',
            'session_id' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id' // Optional fallback for backward compatibility
        ]);

        if ($validator->fails()) {
            Log::warning('Expense parsing validation failed', [
                'errors' => $validator->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        try {
            // Get user from WhatsApp session or number
            $user = $this->getUserFromRequest($request);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or not authenticated via WhatsApp'
                ], 401);
            }

            $userId = $user->id;

            // Check rate limiting
            if ($this->isRateLimited($userId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many requests. Please try again later.'
                ], 429);
            }

            // Get user's existing data with caching
            $userContext = $this->getUserContext($userId);

            // Parse the message using OpenRouter
            $result = $this->openRouterService->parseTransaction(
                $request->message,
                $userContext['categories'],
                $userContext['wallets'],
                $userContext['persons']
            );

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to parse the expense message',
                    'errors' => $result['errors'] ?? [],
                    'processing_time' => $result['processing_time'] ?? 0
                ], 400);
            }

            // Validate parsed data
            $validationResult = $this->validateParsedData($result['parsed_data']);
            if (!$validationResult['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid parsed data',
                    'errors' => $validationResult['errors']
                ], 400);
            }

            // Create new entries if needed
            $createdEntries = $this->createNewEntries($result['new_entries'] ?? [], $userId);

            // Update the parsed data with actual database IDs
            $parsedData = $this->updateParsedDataWithDbIds(
                $result['parsed_data'],
                $createdEntries,
                $userId
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'parsed_expense' => $parsedData,
                    'new_entries_created' => $createdEntries,
                    'processing_time' => $result['processing_time'],
                    'suggestions' => $this->generateSuggestions($parsedData, $userId)
                ],
                'message' => 'Expense parsed successfully'
            ]);
        } catch (Exception $e) {
            Log::error('WhatsApp expense parsing failed', [
                'message' => $request->message,
                'user_id' => $userId ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while parsing the expense',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Create and save a transaction from parsed data
     */
    public function createTransaction(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
            'expense_person_id' => 'nullable|exists:expense_people,id',
            'person_name' => 'nullable|string|max:255',
            'date' => 'nullable|date|before_or_equal:today',
            'notes' => 'nullable|string|max:1000',
            'type' => 'sometimes|in:expense,income',
            'whatsapp_number' => 'sometimes|string',
            'session_id' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id' // Optional fallback
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Get user from WhatsApp session or number
            $user = $this->getUserFromRequest($request);

            if (!$user) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or not authenticated via WhatsApp'
                ], 401);
            }

            $userId = $user->id;

            // Verify ownership of wallet and category
            if (!$this->verifyOwnership($userId, $request->wallet_id, $request->category_id)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to resources'
                ], 403);
            }

            // Handle person creation if needed
            $expensePersonId = $this->handlePersonCreation($request, $userId);

            // Get wallet and check if it's active
            $wallet = Wallet::where('id', $request->wallet_id)
                ->where('user_id', $userId)
                ->where('is_active', true)
                ->first();

            if (!$wallet) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Wallet not found or inactive'
                ], 404);
            }

            // Check if wallet has sufficient balance for expenses
            $transactionType = $request->type ?? 'expense';
            if ($transactionType === 'expense' && $wallet->balance < $request->amount) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient wallet balance'
                ], 400);
            }

            // Create the transaction
            $transaction = Transaction::create([
                'user_id' => $userId,
                'category_id' => $request->category_id,
                'wallet_id' => $request->wallet_id,
                'expense_person_id' => $expensePersonId,
                'amount' => $request->amount,
                'type' => $transactionType,
                'date' => $request->date ?? now()->format('Y-m-d'),
                'note' => $request->notes
            ]);

            // Update wallet balance
            $this->updateWalletBalance($wallet, $request->amount, $transactionType);

            DB::commit();

            // Clear user context cache
            Cache::forget("user_context_{$userId}");

            // Load relationships for response
            $transaction->load(['category:id,name', 'wallet:id,name,balance', 'person:id,name']);

            return response()->json([
                'success' => true,
                'data' => [
                    'transaction' => $transaction,
                    'updated_wallet_balance' => $wallet->balance
                ],
                'message' => 'Transaction created successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Transaction creation failed', [
                'request_data' => $request->except(['notes']), // Don't log sensitive notes
                'user_id' => $userId ?? 'unknown',
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create transaction',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Combined endpoint: Parse and create transaction in one call
     */
    public function parseAndCreate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
            'whatsapp_number' => 'sometimes|string',
            'session_id' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id', // Optional fallback
            'auto_create' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // First parse the message
            $parseRequest = new Request($request->only(['message', 'whatsapp_number', 'session_id', 'user_id']));
            $parseResponse = $this->parseExpense($parseRequest);
            $parseData = $parseResponse->getData(true);

            if (!$parseData['success']) {
                return $parseResponse;
            }

            $parsedExpense = $parseData['data']['parsed_expense'];

            // Validate required fields for auto-creation
            if ($request->boolean('auto_create', false)) {
                $requiredFields = ['amount', 'category_id', 'wallet_id'];
                $missingFields = [];

                foreach ($requiredFields as $field) {
                    if (empty($parsedExpense[$field])) {
                        $missingFields[] = $field;
                    }
                }

                if (!empty($missingFields)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot auto-create transaction. Missing required fields.',
                        'missing_fields' => $missingFields,
                        'parsed_data' => $parseData['data']
                    ], 400);
                }

                // Create transaction with parsed data
                $createRequest = new Request([
                    'amount' => $parsedExpense['amount'],
                    'category_id' => $parsedExpense['category_id'],
                    'wallet_id' => $parsedExpense['wallet_id'],
                    'expense_person_id' => $parsedExpense['expense_person_id'],
                    'person_name' => $parsedExpense['person_name'],
                    'date' => $parsedExpense['date'],
                    'notes' => $parsedExpense['notes'] ?? null,
                    'type' => 'expense'
                ]);

                $createResponse = $this->createTransaction($createRequest);
                $createData = $createResponse->getData(true);

                if ($createData['success']) {
                    return response()->json([
                        'success' => true,
                        'data' => [
                            'parsed_data' => $parseData['data'],
                            'transaction' => $createData['data']['transaction'],
                            'updated_wallet_balance' => $createData['data']['updated_wallet_balance']
                        ],
                        'message' => 'Expense parsed and transaction created successfully'
                    ]);
                } else {
                    Log::error('Transaction creation failed after parsing', [
                        'parsed_data' => $parseData['data'],
                        'create_error' => $createData['message'] ?? 'Unknown error'
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Transaction creation failed',
                        'parsed_data' => $parseData['data'],
                        'creation_error' => $createData['message'] ?? 'Unknown error'
                    ], 400);
                }
            }

            return $parseResponse;
        } catch (Exception $e) {
            Log::error('Parse and create failed', [
                'message' => $request->message,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process expense',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get user's recent transactions for context
     */
    public function getRecentTransactions(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'whatsapp_number' => 'sometimes|string',
            'session_id' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id', // Optional fallback
            'limit' => 'sometimes|integer|min:1|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get user from WhatsApp session or number
            $user = $this->getUserFromRequest($request);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or not authenticated via WhatsApp'
                ], 401);
            }

            $userId = $user->id;

            $limit = min($request->input('limit', 10), 50); // Cap at 50

            $transactions = Transaction::with(['category:id,name', 'wallet:id,name', 'person:id,name'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $transactions,
                'message' => 'Recent transactions retrieved successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to retrieve recent transactions', [
                'user_id' => $userId ?? 'unknown',
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve transactions',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * WhatsApp webhook verification endpoint
     */
    public function webhookVerify(Request $request)
    {
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        $verifyToken = config('services.whatsapp.webhook_token');

        if ($mode === 'subscribe' && $token === $verifyToken) {
            Log::info('WhatsApp webhook verified successfully');
            return response($challenge, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            Log::warning('WhatsApp webhook verification failed', [
                'mode' => $mode ?? 'missing',
                'token' => $token ? 'provided' : 'missing',
                'expected_token' => $verifyToken ? 'configured' : 'not_configured'
            ]);
            return response('Verification failed', 403);
        }
    }

    /**
     * Test WhatsApp authentication endpoint
     */
    public function testWhatsAppAuth(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'whatsapp_number' => 'sometimes|string',
            'session_id' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $validation = $this->validateWhatsAppUser($request);
            
            if (!$validation['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $validation['message']
                ], $validation['code']);
            }

            $user = $validation['user'];
            $session = $this->getOrCreateSessionFromRequest($request);

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'whatsapp_number' => $user->whatsapp_number,
                        'whatsapp_status' => $user->whatsapp_status
                    ],
                    'session' => $session ? [
                        'id' => $session->id,
                        'state' => $session->state,
                        'created_at' => $session->created_at
                    ] : null,
                    'authentication_method' => $this->getAuthMethodUsed($request)
                ],
                'message' => 'WhatsApp authentication successful'
            ]);

        } catch (Exception $e) {
            Log::error('WhatsApp auth test failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Authentication test failed',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get which authentication method was used
     */
    protected function getAuthMethodUsed(Request $request): string
    {
        if ($request->has('session_id')) {
            return 'whatsapp_session_id';
        }
        if ($request->has('whatsapp_number')) {
            return 'whatsapp_number';
        }
        if ($request->has('user_id')) {
            return 'user_id_fallback';
        }
        return 'none';
    }

    /**
     * WhatsApp webhook receiver - Improved flow
     */
    public function webhookReceive(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            
            // Log incoming webhook for debugging
            Log::info('WhatsApp webhook received', [
                'payload_keys' => array_keys($data),
                'has_entry' => isset($data['entry']),
                'entry_count' => isset($data['entry']) ? count($data['entry']) : 0
            ]);

            // Validate webhook structure
            if (!$this->isValidWebhookPayload($data)) {
                Log::warning('Invalid WhatsApp webhook payload structure', ['data' => $data]);
                return response()->json(['status' => 'invalid_payload'], 200);
            }

            // Parse incoming message
            $messageData = $this->parseIncomingMessage($data);

            if (!$messageData) {
                Log::info('No processable message found in webhook');
                return response()->json(['status' => 'no_message'], 200);
            }

            $fromNumber = $messageData['from'];
            $messageType = $messageData['type'] ?? null;

            Log::info('Processing WhatsApp message', [
                'from' => $fromNumber,
                'type' => $messageType,
                'has_message_text' => isset($messageData['message']),
                'has_button_id' => isset($messageData['button_id']),
                'has_list_id' => isset($messageData['list_id']),
                'has_media' => isset($messageData['media_id'])
            ]);

            // Handle different message types
            switch ($messageType) {
                case 'text':
                    $messageText = $messageData['message'] ?? '';
                    $this->handleTextMessage($fromNumber, $messageText);
                    break;

                case 'interactive':
                    $this->handleInteractiveMessage($fromNumber, $messageData);
                    break;

                case 'image':
                case 'document':
                case 'audio':
                case 'video':
                    $this->handleMediaMessage($fromNumber, $messageData);
                    break;

                default:
                    Log::info('Unsupported message type received', [
                        'type' => $messageType,
                        'from' => $fromNumber
                    ]);
                    $this->sendTextMessage($fromNumber, "Sorry, I can only process text messages and button interactions at the moment.");
            }

            return response()->json(['status' => 'processed'], 200);

        } catch (Exception $e) {
            Log::error('WhatsApp webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Validate WhatsApp webhook payload structure
     */
    protected function isValidWebhookPayload(array $data): bool
    {
        // Check basic webhook structure
        if (!isset($data['entry']) || !is_array($data['entry']) || empty($data['entry'])) {
            return false;
        }

        $entry = $data['entry'][0] ?? null;
        if (!$entry || !isset($entry['changes']) || !is_array($entry['changes'])) {
            return false;
        }

        $change = $entry['changes'][0] ?? null;
        if (!$change || !isset($change['value'])) {
            return false;
        }

        return true;
    }

    // ============== PROTECTED HELPER METHODS ==============

    /**
     * Check if user is rate limited
     */
    protected function isRateLimited(int $userId): bool
    {
        $key = "rate_limit_parse_{$userId}";
        $attempts = Cache::get($key, 0);

        if ($attempts >= self::RATE_LIMIT_ATTEMPTS) {
            return true;
        }

        Cache::put($key, $attempts + 1, now()->addMinutes(self::RATE_LIMIT_MINUTES));
        return false;
    }

    /**
     * Get user context with caching
     */
    protected function getUserContext(int $userId): array
    {
        if (!$userId) {
            return [
                'categories' => [],
                'wallets' => [],
                'persons' => []
            ];
        }

        return Cache::remember("user_context_{$userId}", 300, function () use ($userId) {
            return [
                'categories' => Category::where('user_id', $userId)
                    ->select('id', 'name')
                    ->get()
                    ->map(fn($cat) => ['id' => (string)$cat->id, 'name' => $cat->name])
                    ->toArray(),

                'wallets' => Wallet::where('user_id', $userId)
                    ->where('is_active', true)
                    ->select('id', 'name')
                    ->get()
                    ->map(fn($wallet) => ['id' => (string)$wallet->id, 'name' => $wallet->name])
                    ->toArray(),

                'persons' => ExpensePerson::where('user_id', $userId)
                    ->select('id', 'name')
                    ->get()
                    ->map(fn($person) => ['id' => (string)$person->id, 'name' => $person->name])
                    ->toArray()
            ];
        });
    }

    /**
     * Validate parsed data
     */
    protected function validateParsedData(array $parsedData): array
    {
        $errors = [];

        if (!isset($parsedData['amount']) || !is_numeric($parsedData['amount']) || $parsedData['amount'] <= 0) {
            $errors[] = 'Invalid amount';
        }

        if (empty($parsedData['category'])) {
            $errors[] = 'Category is required';
        }

        if (empty($parsedData['wallet'])) {
            $errors[] = 'Wallet is required';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Verify user ownership of resources
     */
    protected function verifyOwnership(int $userId, int $walletId, int $categoryId): bool
    {
        $walletExists = Wallet::where('id', $walletId)->where('user_id', $userId)->exists();
        $categoryExists = Category::where('id', $categoryId)->where('user_id', $userId)->exists();

        return $walletExists && $categoryExists;
    }

    /**
     * Handle person creation logic
     */
    protected function handlePersonCreation(Request $request, int $userId): ?int
    {
        if (!$request->person_name || $request->person_name === 'Self') {
            return null;
        }

        if ($request->expense_person_id) {
            // Verify ownership
            $person = ExpensePerson::where('id', $request->expense_person_id)
                ->where('user_id', $userId)
                ->first();
            return $person ? $person->id : null;
        }

        // Create new person
        $person = ExpensePerson::create([
            'user_id' => $userId,
            'name' => $request->person_name
        ]);

        return $person->id;
    }

    /**
     * Update wallet balance
     */
    protected function updateWalletBalance(Wallet $wallet, float $amount, string $type): void
    {
        if ($type === 'income') {
            $wallet->balance += $amount;
        } else {
            $wallet->balance -= $amount;
        }
        $wallet->save();
    }

    /**
     * Parse incoming WhatsApp message
     */
    protected function parseIncomingMessage(array $data): ?array
    {
        try {
            // Safely extract the message object with multiple fallback checks
            $messageObject = data_get($data, 'entry.0.changes.0.value.messages.0');
            
            if (!$messageObject || !is_array($messageObject)) {
                Log::warning('WhatsApp webhook: No valid message object found', ['data' => $data]);
                return null;
            }

            $fromNumber = $messageObject['from'] ?? null;
            $messageType = $messageObject['type'] ?? null;

            if (!$fromNumber || !$messageType) {
                Log::warning('WhatsApp webhook: Missing from number or message type', [
                    'from' => $fromNumber,
                    'type' => $messageType,
                    'message_object' => $messageObject
                ]);
                return null;
            }

            $result = [
                'from' => $fromNumber,
                'type' => $messageType,
                'timestamp' => $messageObject['timestamp'] ?? time()
            ];

            // Handle different message types
            switch ($messageType) {
                case 'text':
                    $textBody = data_get($messageObject, 'text.body');
                    if ($textBody) {
                        $result['message'] = trim($textBody);
                    }
                    break;

                case 'interactive':
                    // Handle button replies
                    $buttonId = data_get($messageObject, 'interactive.button_reply.id');
                    if ($buttonId) {
                        $result['button_id'] = $buttonId;
                        $result['button_title'] = data_get($messageObject, 'interactive.button_reply.title');
                    }
                    
                    // Handle list replies
                    $listId = data_get($messageObject, 'interactive.list_reply.id');
                    if ($listId) {
                        $result['list_id'] = $listId;
                        $result['list_title'] = data_get($messageObject, 'interactive.list_reply.title');
                    }
                    break;

                case 'image':
                case 'document':
                case 'audio':
                case 'video':
                    $result['media_id'] = data_get($messageObject, "$messageType.id");
                    $result['caption'] = data_get($messageObject, "$messageType.caption", '');
                    break;

                default:
                    Log::info('WhatsApp webhook: Unsupported message type', [
                        'type' => $messageType,
                        'from' => $fromNumber
                    ]);
                    return null;
            }

            // Ensure we have actionable content
            $hasContent = isset($result['message']) || 
                         isset($result['button_id']) || 
                         isset($result['list_id']) || 
                         isset($result['media_id']);

            if (!$hasContent) {
                Log::warning('WhatsApp webhook: Message has no actionable content', $result);
                return null;
            }

            Log::info('WhatsApp webhook: Successfully parsed message', $result);
            return $result;

        } catch (\Exception $e) {
            Log::error('WhatsApp webhook: Error parsing message', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return null;
        }
    }

    /**
     * Handle text messages with state management
     */
    protected function handleTextMessage(string $fromNumber, string $messageText): void
    {
        $session = $this->getOrCreateSession($fromNumber);
        $user = User::where('whatsapp_number', $fromNumber)->first();

        // Handle based on current session state
        switch ($session->state) {
            case 'awaiting_email':
                $this->handleEmailInput($fromNumber, $messageText, $session);
                break;

            case 'awaiting_otp':
                $this->handleOtpInput($fromNumber, $messageText, $session);
                break;

            case 'awaiting_expense':
                $this->handleExpenseInput($fromNumber, $messageText, $session, $user);
                break;
                
            case 'awaiting_wallet_selection':
                $this->handleWalletSelection($fromNumber, $messageText, $session, $user);
                break;

            default:
                if ($user && $user->whatsapp_status === 'verified') {
                    // Check if it's an expense message
                    if ($this->looksLikeExpense($messageText)) {
                        $this->handleExpenseInput($fromNumber, $messageText, $session, $user);
                    } else {
                        $this->sendLinkedMenu($fromNumber);
                    }
                } else {
                    $this->initiateUserFlow($fromNumber, $user, $session);
                }
        }
    }

    /**
     * Handle interactive button responses
     */
    protected function handleInteractiveMessage(string $fromNumber, array $messageData): void
    {
        $session = $this->getOrCreateSession($fromNumber);
        $user = User::where('whatsapp_number', $fromNumber)->first();

        // Handle button replies
        if (isset($messageData['button_id'])) {
            $buttonId = $messageData['button_id'];
            
            switch ($buttonId) {
                case 'new_entry':
                    $session->update(['state' => 'awaiting_expense']);
                    $this->sendTextMessage($fromNumber, "💰 Please describe your expense:\n\nExample: \"Spent 50 on groceries from Cash wallet\"");
                    break;

                case 'view_wallets':
                    $this->sendWalletsList($fromNumber, $user);
                    break;

                case 'view_categories':
                    $this->sendCategoriesList($fromNumber, $user);
                    break;

                case 'link_account':
                    $this->askForEmail($fromNumber, $session);
                    break;

                default:
                    Log::info('WhatsApp: Unknown button ID', ['button_id' => $buttonId, 'from' => $fromNumber]);
                    $this->sendLinkedMenu($fromNumber);
            }
        }
        
        // Handle list replies
        elseif (isset($messageData['list_id'])) {
            $listId = $messageData['list_id'];
            
            // Handle wallet selection from list
            if (str_starts_with($listId, 'wallet_') && $session->state === 'awaiting_wallet_selection') {
                $walletId = str_replace('wallet_', '', $listId);
                $this->handleWalletSelection($fromNumber, $walletId, $session, $user);
            } else {
                Log::info('WhatsApp: Unknown list selection', ['list_id' => $listId, 'from' => $fromNumber]);
                $this->sendLinkedMenu($fromNumber);
            }
        }
        
        // No recognizable interactive content
        else {
            Log::warning('WhatsApp: Interactive message without button_id or list_id', $messageData);
            $this->sendLinkedMenu($fromNumber);
        }
    }

    /**
     * Handle media messages (images, documents, etc.)
     */
    protected function handleMediaMessage(string $fromNumber, array $messageData): void
    {
        $session = $this->getOrCreateSession($fromNumber);
        $user = User::where('whatsapp_number', $fromNumber)->first();

        // Check if user is authenticated
        if (!$user || $user->whatsapp_status !== 'verified') {
            $this->sendTextMessage($fromNumber, "Please link your account first before sending media files.");
            $this->initiateUserFlow($fromNumber, $user, $session);
            return;
        }

        $mediaType = $messageData['type'] ?? 'unknown';
        $caption = $messageData['caption'] ?? '';

        Log::info('WhatsApp: Media message received', [
            'from' => $fromNumber,
            'type' => $mediaType,
            'has_caption' => !empty($caption),
            'media_id' => $messageData['media_id'] ?? null
        ]);

        // If there's a caption, try to process it as an expense
        if (!empty($caption) && $this->looksLikeExpense($caption)) {
            $this->handleExpenseInput($fromNumber, $caption, $session, $user);
        } else {
            // For now, just acknowledge the media
            $this->sendTextMessage($fromNumber, 
                "📎 I received your " . $mediaType . " file. " .
                (!empty($caption) ? "However, I couldn't process it as an expense. " : "") .
                "Please send a text message describing your expense instead.\n\n" .
                "Example: \"Spent 50 on groceries from Cash wallet\""
            );
        }
    }

    /**
     * Check if message looks like an expense
     */
    protected function looksLikeExpense(string $message): bool
    {
        $expenseKeywords = ['spent', 'paid', 'bought', 'cost', 'expense', 'bill', 'purchase'];
        $message = strtolower($message);

        foreach ($expenseKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }

        // Check for number patterns (amount)
        return preg_match('/\d+(\.\d+)?/', $message);
    }

    /**
     * Get or create session with timeout handling
     */
    protected function getOrCreateSession(string $fromNumber): WhatsappSession
    {
        $session = WhatsappSession::where('whatsapp_number', $fromNumber)
            ->where('created_at', '>', now()->subMinutes(self::SESSION_TIMEOUT_MINUTES))
            ->latest('created_at')
            ->first();

        if (!$session || $session->state === 'finished') {
            $session = WhatsappSession::create([
                'whatsapp_number' => $fromNumber,
                'state' => 'start',
                'last_message_at' => now(),
            ]);
        }

        return $session;
    }

    /**
     * Handle email input
     */
    protected function handleEmailInput(string $fromNumber, string $email, WhatsappSession $session): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->sendTextMessage($fromNumber, "❌ Invalid email format. Please enter a valid email address.");
            return;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update(['whatsapp_number' => $fromNumber, 'whatsapp_status' => 'pending']);
            $this->initiateOtpVerification($user, $fromNumber, $session);
        } else {
            $this->sendTextMessage($fromNumber, "❌ No account found with this email. Please check and try again or contact support.");
            $session->update(['state' => 'start']);
        }
    }

    /**
     * Handle OTP input
     */
    protected function handleOtpInput(string $fromNumber, string $otp, WhatsappSession $session): void
    {
        // Validate OTP format (6 digits)
        if (!preg_match('/^\d{6}$/', $otp)) {
            $this->sendTextMessage($fromNumber, "❌ Please enter a valid 6-digit OTP code.");
            return;
        }

        $tempData = $session->temp_data ?? [];
        $storedOtp = $tempData['otp'] ?? null;
        $generatedAt = $tempData['generated_at'] ?? null;

        // Check if OTP has expired (15 minutes)
        if ($generatedAt && now()->diffInMinutes($generatedAt) > 15) {
            $this->sendTextMessage($fromNumber, "❌ OTP has expired. Please request a new one.");
            $session->update(['state' => 'start']);
            return;
        }

        if ($otp === (string)$storedOtp) {
            $user = User::where('whatsapp_number', $fromNumber)->first();
            if ($user) {
                $user->update(['whatsapp_status' => 'verified']);
                $session->update(['state' => 'finished']);
                $this->sendTextMessage($fromNumber, "✅ Verification successful! Welcome to Expense Tracker.");
                $this->sendLinkedMenu($fromNumber);
            }
        } else {
            $this->sendTextMessage($fromNumber, "❌ Invalid OTP. Please try again.");
        }
    }

    /**
     * Handle expense input
     */
    protected function handleExpenseInput(string $fromNumber, string $message, WhatsappSession $session, User $user): void
    {
        if (!$user) {
            $this->sendTextMessage($fromNumber, "❌ Please link your account first.");
            return;
        }

        try {
            // Parse the expense using the API with WhatsApp session context
            $request = new Request(['message' => $message, 'whatsapp_number' => $fromNumber]);
            $response = $this->parseExpense($request);
            $data = $response->getData(true);

            if ($data['success']) {
                $parsedData = $data['data']['parsed_expense'];

                // Check if wallet selection is needed
                if (!empty($parsedData['needs_wallet_selection'])) {
                    // Store the parsed data in session and ask for wallet selection
                    $session->update([
                        'state' => 'awaiting_wallet_selection',
                        'temp_data' => [
                            'parsed_expense' => $parsedData,
                            'original_message' => $message
                        ]
                    ]);
                    $this->sendWalletSelectionMenu($fromNumber, $user);
                    return;
                }

                // Auto-create if all required data is present
                if ($this->canAutoCreate($parsedData)) {
                    $createRequest = new Request([
                        'message' => $message,
                        'auto_create' => true,
                        'whatsapp_number' => $fromNumber,
                    ]);

                    $createResponse = $this->parseAndCreate($createRequest);
                    $createData = $createResponse->getData(true);

                    if ($createData['success']) {
                        $transaction = $createData['data']['transaction'];
                        $this->sendTextMessage(
                            $fromNumber,
                            "✅ Expense recorded successfully!\n\n" .
                                "💰 Amount: {$transaction['amount']}\n" .
                                "📂 Category: {$transaction['category']['name']}\n" .
                                "💳 Wallet: {$transaction['wallet']['name']}"
                        );
                    } else {
                        $this->sendTextMessage($fromNumber, "❌ Failed to create expense: " . ($createData['message'] ?? 'Unknown error'));
                    }
                } else {
                    // Send confirmation message for manual review
                    $this->sendExpenseConfirmation($fromNumber, $parsedData);
                }
            } else {
                $this->sendTextMessage($fromNumber, "❌ Couldn't understand the expense. Please try again with format: 'Spent [amount] on [description]'");
            }

            $session->update(['state' => 'start']);
        } catch (Exception $e) {
            Log::error('Expense processing failed', ['error' => $e->getMessage()]);
            $this->sendTextMessage($fromNumber, "❌ An error occurred. Please try again.");
            $session->update(['state' => 'start']);
        }
    }

    /**
     * Check if expense can be auto-created
     */
    protected function canAutoCreate(array $parsedData): bool
    {
        return !empty($parsedData['amount']) &&
            !empty($parsedData['category_id']) &&
            !empty($parsedData['wallet_id']) &&
            empty($parsedData['needs_wallet_selection']);
    }

    /**
     * Send expense confirmation message
     */
    protected function sendExpenseConfirmation(string $fromNumber, array $parsedData): void
    {
        if (!empty($parsedData['needs_wallet_selection'])) {
            $message = "📊 Expense parsed:\n\n" .
                "💰 Amount: " . ($parsedData['amount'] ?? 'Not detected') . "\n" .
                "📂 Category: " . ($parsedData['category_name'] ?? 'Not detected') . "\n" .
                "💳 Wallet: Please select from your wallets\n\n" .
                "Wallet selection needed - check your wallets in the app.";
        } else {
            $message = "📊 Expense parsed:\n\n" .
                "💰 Amount: " . ($parsedData['amount'] ?? 'Not detected') . "\n" .
                "📂 Category: " . ($parsedData['category_name'] ?? 'Not detected') . "\n" .
                "💳 Wallet: " . ($parsedData['wallet_name'] ?? 'Not detected') . "\n\n" .
                "Please review and confirm in the app.";
        }

        $this->sendTextMessage($fromNumber, $message);
    }

    // ...existing code for other methods...

    /**
     * Create new entries (categories only) that don't exist
     */
    protected function createNewEntries(array $newEntries, int $userId): array
    {
        $created = [
            'categories' => [],
            'wallets' => [],
            'persons' => []
        ];

        try {
            // Create new categories only
            foreach ($newEntries['categories'] ?? [] as $categoryData) {
                $category = Category::create([
                    'user_id' => $userId,
                    'name' => $categoryData['name']
                ]);
                $created['categories'][$categoryData['id']] = $category;
            }

            // Don't create wallets automatically - user must select from existing ones

            // Create new persons
            foreach ($newEntries['persons'] ?? [] as $personData) {
                $person = ExpensePerson::create([
                    'user_id' => $userId,
                    'name' => $personData['name']
                ]);
                $created['persons'][$personData['id']] = $person;
            }
        } catch (Exception $e) {
            Log::error('Failed to create new entries', [
                'user_id' => $userId,
                'new_entries' => $newEntries,
                'error' => $e->getMessage()
            ]);
        }

        return $created;
    }

    /**
     * Update parsed data with actual database IDs
     */
    protected function updateParsedDataWithDbIds(array $parsedData, array $createdEntries, int $userId): array
    {
        $updated = $parsedData;

        // Update category ID - create if new, use existing if found
        if (isset($parsedData['category']) && str_starts_with($parsedData['category'], 'NEW_CATEGORY_')) {
            $updated['category_id'] = $createdEntries['categories'][$parsedData['category']]->id ?? null;
            $updated['category_name'] = $createdEntries['categories'][$parsedData['category']]->name ?? 'Unknown';
        } elseif (isset($parsedData['category']) && is_numeric($parsedData['category'])) {
            $updated['category_id'] = (int)$parsedData['category'];
            $category = Category::where('id', $updated['category_id'])
                ->where('user_id', $userId)
                ->first();
            $updated['category_name'] = $category ? $category->name : 'Unknown';
        }

        // Update wallet ID - NEVER create new wallets, only use existing ones
        if (isset($parsedData['wallet'])) {
            if (str_starts_with($parsedData['wallet'], 'NEW_WALLET_')) {
                // Mark that wallet needs to be selected
                $updated['wallet_id'] = null;
                $updated['wallet_name'] = null;
                $updated['needs_wallet_selection'] = true;
            } elseif (is_numeric($parsedData['wallet'])) {
                $walletId = (int)$parsedData['wallet'];
                $wallet = Wallet::where('id', $walletId)
                    ->where('user_id', $userId)
                    ->where('is_active', true)
                    ->first();
                
                if ($wallet) {
                    $updated['wallet_id'] = $wallet->id;
                    $updated['wallet_name'] = $wallet->name;
                } else {
                    $updated['wallet_id'] = null;
                    $updated['wallet_name'] = null;
                    $updated['needs_wallet_selection'] = true;
                }
            }
        }

        // Update person ID
        if (isset($parsedData['person'])) {
            if ($parsedData['person'] === 'Self') {
                $updated['expense_person_id'] = null;
                $updated['person_name'] = 'Self';
            } elseif (str_starts_with($parsedData['person'], 'NEW_PERSON_')) {
                $updated['expense_person_id'] = $createdEntries['persons'][$parsedData['person']]->id ?? null;
                $updated['person_name'] = $createdEntries['persons'][$parsedData['person']]->name ?? 'Unknown';
            } else {
                $updated['expense_person_id'] = (int)$parsedData['person'];
                $person = ExpensePerson::where('id', $updated['expense_person_id'])
                    ->where('user_id', $userId)
                    ->first();
                $updated['person_name'] = $person ? $person->name : 'Unknown';
            }
        }

        return $updated;
    }

    /**
     * Generate suggestions based on user's transaction history
     */
    protected function generateSuggestions(array $parsedData, int $userId): array
    {
        $suggestions = [];

        try {
            if (isset($parsedData['amount'])) {
                // Get most used categories for similar amounts
                $similarAmountCategories = Transaction::where('user_id', $userId)
                    ->whereBetween('amount', [$parsedData['amount'] * 0.8, $parsedData['amount'] * 1.2])
                    ->with('category:id,name')
                    ->get()
                    ->pluck('category.name')
                    ->filter()
                    ->countBy()
                    ->sortDesc()
                    ->take(3)
                    ->keys()
                    ->toArray();

                if (!empty($similarAmountCategories)) {
                    $suggestions['similar_amount_categories'] = $similarAmountCategories;
                }
            }

            // Get most used wallets
            $commonWallets = Transaction::where('user_id', $userId)
                ->with('wallet:id,name')
                ->get()
                ->pluck('wallet.name')
                ->filter()
                ->countBy()
                ->sortDesc()
                ->take(3)
                ->keys()
                ->toArray();

            if (!empty($commonWallets)) {
                $suggestions['common_wallets'] = $commonWallets;
            }
        } catch (Exception $e) {
            Log::warning('Failed to generate suggestions', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
        }

        return $suggestions;
    }

    /**
     * Initiate user flow based on status
     */
    protected function initiateUserFlow(string $fromNumber, ?User $user, WhatsappSession $session): void
    {
        if ($user) {
            if ($user->whatsapp_status === 'verified') {
                $this->sendLinkedMenu($fromNumber);
            } elseif (in_array($user->whatsapp_status, ['pending', 'unverified'])) {
                $this->initiateOtpVerification($user, $fromNumber, $session);
            }
        } else {
            $this->askForEmail($fromNumber, $session);
        }
    }

    /**
     * Ask the user for their email
     */
    protected function askForEmail(string $fromNumber, WhatsappSession $session): void
    {
        $this->sendTextMessage($fromNumber, "👋 Welcome to Expense Tracker!\n\nPlease enter the email address you used to sign up:");
        $session->update(['state' => 'awaiting_email']);
    }

    /**
     * Initiate OTP verification
     */
    protected function initiateOtpVerification(User $user, string $fromNumber, WhatsappSession $session): void
    {
        $otp = rand(100000, 999999);

        $session->update([
            'state' => 'awaiting_otp',
            'temp_data' => ['otp' => $otp, 'generated_at' => now()->toISOString()]
        ]);

        // Send OTP via email
        try {
            $emailContent = $this->createOtpEmailTemplate($user->name ?? 'User', $otp);

            Mail::raw($emailContent, function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('🔐 Your WhatsApp Verification Code - Expense Tracker');
            });
        } catch (Exception $e) {
            Log::error('Failed to send OTP email', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        $this->sendTextMessage($fromNumber, "🔐 We've sent a verification code to your email: {$user->email}\n\nPlease reply with the 6-digit code to verify your WhatsApp account.");
    }

    /**
     * Send linked user menu
     */
    protected function sendLinkedMenu(string $fromNumber): void
    {
        $this->sendInteractiveButtons($fromNumber, "🏠 Main Menu\n\nWhat would you like to do?", [
            ['id' => 'new_entry', 'title' => 'Add Expense'],
            ['id' => 'view_wallets', 'title' => 'View Wallets'],
            ['id' => 'view_categories', 'title' => 'Categories']
        ]);
    }

    /**
     * Send wallets list
     */
    protected function sendWalletsList(string $fromNumber, User $user): void
    {
        $wallets = Wallet::where('user_id', $user->id)
            ->where('is_active', true)
            ->select('name', 'balance')
            ->get();

        if ($wallets->isEmpty()) {
            $this->sendTextMessage($fromNumber, "💳 No wallets found. Please add wallets in the app first.");
            return;
        }

        $message = "💰 Your Wallets:\n\n";
        foreach ($wallets as $wallet) {
            $message .= "💳 {$wallet->name}: {$wallet->balance}\n";
        }

        $this->sendTextMessage($fromNumber, $message);
    }

    /**
     * Send categories list
     */
    protected function sendCategoriesList(string $fromNumber, User $user): void
    {
        $categories = Category::where('user_id', $user->id)
            ->select('name')
            ->orderBy('name')
            ->get();

        if ($categories->isEmpty()) {
            $this->sendTextMessage($fromNumber, "📂 No categories found. Please add categories in the app first.");
            return;
        }

        $message = "📂 Your Categories:\n\n";
        foreach ($categories as $category) {
            $message .= "• {$category->name}\n";
        }

        $this->sendTextMessage($fromNumber, $message);
    }

    /**
     * Helper: Send interactive buttons
     */
    protected function sendInteractiveButtons(string $to, string $text, array $buttons): void
    {
        try {
            $phoneNumberId = config('services.whatsapp.phone_number_id');
            $apiToken = config('services.whatsapp.api_token');
            $apiUrl = config('services.whatsapp.api_url');

            if (!$phoneNumberId || !$apiToken || !$apiUrl) {
                Log::error('WhatsApp configuration missing', [
                    'phone_number_id' => $phoneNumberId ? 'configured' : 'missing',
                    'api_token' => $apiToken ? 'configured' : 'missing',
                    'api_url' => $apiUrl ? 'configured' : 'missing'
                ]);
                return;
            }

            $url = $apiUrl . $phoneNumberId . '/messages';

            $payload = [
                "messaging_product" => "whatsapp",
                "to" => $to,
                "type" => "interactive",
                "interactive" => [
                    "type" => "button",
                    "body" => ["text" => $text],
                    "action" => [
                        "buttons" => array_map(function ($b) {
                            return [
                                "type" => "reply",
                                "reply" => ["id" => $b['id'], "title" => $b['title']]
                            ];
                        }, $buttons)
                    ]
                ]
            ];

            $response = Http::withToken($apiToken)
                ->timeout(10)
                ->post($url, $payload);

            if (!$response->successful()) {
                Log::error('Failed to send interactive buttons', [
                    'to' => $to,
                    'response' => $response->body(),
                    'status' => $response->status()
                ]);
            }
        } catch (Exception $e) {
            Log::error('Failed to send WhatsApp interactive message', [
                'to' => $to,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Helper: Send plain text message
     */
    protected function sendTextMessage(string $to, string $text): void
    {
        try {
            $phoneNumberId = config('services.whatsapp.phone_number_id');
            $apiToken = config('services.whatsapp.api_token');
            $apiUrl = config('services.whatsapp.api_url');

            if (!$phoneNumberId || !$apiToken || !$apiUrl) {
                Log::error('WhatsApp configuration missing', [
                    'phone_number_id' => $phoneNumberId ? 'configured' : 'missing',
                    'api_token' => $apiToken ? 'configured' : 'missing',
                    'api_url' => $apiUrl ? 'configured' : 'missing'
                ]);
                return;
            }

            $url = $apiUrl . $phoneNumberId . '/messages';

            $payload = [
                "messaging_product" => "whatsapp",
                "to" => $to,
                "type" => "text",
                "text" => ["body" => $text]
            ];

            $response = Http::withToken($apiToken)
                ->timeout(10)
                ->post($url, $payload);

            if (!$response->successful()) {
                Log::error('Failed to send text message', [
                    'to' => $to,
                    'response' => $response->body(),
                    'status' => $response->status()
                ]);
            }
        } catch (Exception $e) {
            Log::error('Failed to send WhatsApp text message', [
                'to' => $to,
                'text' => $text,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send wallet selection menu with numbered options
     */
    protected function sendWalletSelectionMenu(string $fromNumber, User $user): void
    {
        $wallets = Wallet::where('user_id', $user->id)
            ->where('is_active', true)
            ->select('id', 'name', 'balance')
            ->orderBy('name')
            ->get();

        if ($wallets->isEmpty()) {
            $this->sendTextMessage($fromNumber, "❌ No wallets found. Please add wallets in the app first.");
            return;
        }

        $message = "💳 Please select a wallet for your expense:\n\n";
        foreach ($wallets as $index => $wallet) {
            $number = $index + 1;
            $message .= "{$number}. {$wallet->name} (Balance: {$wallet->balance})\n";
        }
        $message .= "\nReply with the number (1-{$wallets->count()}) to select:";

        $this->sendTextMessage($fromNumber, $message);
    }

    /**
     * Handle wallet selection input
     */
    protected function handleWalletSelection(string $fromNumber, string $input, WhatsappSession $session, ?User $user): void
    {
        if (!$user) {
            $this->sendTextMessage($fromNumber, "❌ Please link your account first.");
            return;
        }

        // Validate input is a number
        if (!is_numeric($input)) {
            $this->sendTextMessage($fromNumber, "❌ Please enter a valid number.");
            return;
        }

        $selectedNumber = (int)$input;
        
        // Get user's wallets
        $wallets = Wallet::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        if ($selectedNumber < 1 || $selectedNumber > $wallets->count()) {
            $this->sendTextMessage($fromNumber, "❌ Invalid selection. Please choose a number between 1 and {$wallets->count()}.");
            return;
        }

        $selectedWallet = $wallets[$selectedNumber - 1];
        
        try {
            // Get stored parsed data from session
            $tempData = $session->temp_data ?? [];
            $parsedExpense = $tempData['parsed_expense'] ?? null;

            if (!$parsedExpense) {
                $this->sendTextMessage($fromNumber, "❌ Session expired. Please send your expense message again.");
                $session->update(['state' => 'start']);
                return;
            }

            // Update parsed data with selected wallet
            $parsedExpense['wallet_id'] = $selectedWallet->id;
            $parsedExpense['wallet_name'] = $selectedWallet->name;
            unset($parsedExpense['needs_wallet_selection']);

            // Now try to create the transaction
            $createRequest = new Request([
                'amount' => $parsedExpense['amount'],
                'category_id' => $parsedExpense['category_id'],
                'wallet_id' => $parsedExpense['wallet_id'],
                'expense_person_id' => $parsedExpense['expense_person_id'] ?? null,
                'person_name' => $parsedExpense['person_name'] ?? null,
                'date' => $parsedExpense['date'] ?? null,
                'notes' => $parsedExpense['notes'] ?? null,
                'type' => 'expense'
            ]);

            $createResponse = $this->createTransaction($createRequest);
            $createData = $createResponse->getData(true);

            if ($createData['success']) {
                $transaction = $createData['data']['transaction'];
                $this->sendTextMessage(
                    $fromNumber,
                    "✅ Expense recorded successfully!\n\n" .
                        "💰 Amount: {$transaction['amount']}\n" .
                        "📂 Category: {$transaction['category']['name']}\n" .
                        "💳 Wallet: {$transaction['wallet']['name']}"
                );
            } else {
                $this->sendTextMessage($fromNumber, "❌ Failed to create expense: " . ($createData['message'] ?? 'Unknown error'));
            }

            $session->update(['state' => 'start']);

        } catch (Exception $e) {
            Log::error('Wallet selection processing failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            $this->sendTextMessage($fromNumber, "❌ An error occurred. Please try again.");
            $session->update(['state' => 'start']);
        }
    }

    /**
     * Create OTP email template
     */
    protected function createOtpEmailTemplate(string $userName, int $otp): string
    {
        $appName = config('app.name', 'Cazhoo');

        return "
                🔐 WhatsApp Verification - Expense Tracker

                Hello {$userName},

                Your verification code for linking your WhatsApp account is:

                {$otp}

                This code will expire in 15 minutes for security reasons.

                If you didn't request this verification, please ignore this email.

                Best regards,
                {$appName} Support Team

                ---
                This is an automated message. Please do not reply to this email.";
    }
}
