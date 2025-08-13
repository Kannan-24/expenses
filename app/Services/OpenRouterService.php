<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

/**
 * OpenRouterService
 *
 * This service handles WhatsApp integration for expense parsing using OpenRouter AI.
 * 
 * Features:
 *  - Builds a strict prompt for AI parsing
 *  - Sends requests to OpenRouter using configurable AI models
 *  - Receives and cleans AI responses (ensures valid JSON)
 *  - Canonicalizes category/wallet/person to provided lists (case-insensitive, ignore extra spaces)
 *  - Creates NEW_* ids when no match found
 *  - Validates schema and types
 *  - Includes caching for better performance
 *  - Enhanced error handling and logging
 *
 * Usage:
 *   $service = app(\App\Services\OpenRouterService::class);
 *   $result = $service->parseTransaction($message, $categories, $wallets, $persons);
 *
 * Returned structure:
 * [
 *   'success' => bool,
 *   'parsed_data' => [ ... validated schema ... ],
 *   'new_entries' => [
 *       'categories' => [  ],
 *       'wallets'    => [  ],
 *       'persons'    => [  ],
 *   ],
 *   'raw_ai_response' => string (optional),
 *   'processing_time' => float,
 *   'errors' => array
 * ]
 */
class OpenRouterService
{
    protected string $endpoint;
    protected string $apiKey;
    protected string $model;
    protected int $timeoutSeconds;
    protected int $maxRetries;
    protected int $cacheMinutes;
    protected bool $enableCaching;
    protected bool $enableDebugLogging;

    public function __construct()
    {
        $this->endpoint = config('services.openrouter.url', env('OPENROUTER_URL', 'https://openrouter.ai/api/v1/chat/completions'));
        $this->apiKey = config('services.openrouter.key', env('OPENROUTER_API_KEY'));
        $this->model = config('services.openrouter.model', env('OPENROUTER_MODEL', 'mistralai/mistral-7b-instruct'));
        $this->timeoutSeconds = config('services.openrouter.timeout', env('OPENROUTER_TIMEOUT', 30));
        $this->maxRetries = config('services.openrouter.max_retries', env('OPENROUTER_MAX_RETRIES', 2));
        $this->cacheMinutes = config('services.openrouter.cache_minutes', env('OPENROUTER_CACHE_MINUTES', 5));
        $this->enableCaching = config('services.openrouter.enable_caching', env('OPENROUTER_ENABLE_CACHING', false));
        $this->enableDebugLogging = config('services.openrouter.debug_logging', env('OPENROUTER_DEBUG_LOGGING', false));
    }

    /**
     * Main entry point with enhanced error handling and performance monitoring.
     *
     * @param string $userMessage
     * @param array $categories Array of objects: [ ['id'=>'c_1','name'=>'Groceries'], ... ]
     * @param array $wallets    Array of objects: [ ['id'=>'w_1','name'=>'HDFC'], ... ]
     * @param array $persons    Array of objects: [ ['id'=>'p_1','name'=>'Ramesh'], ... ]
     *
     * @return array
     */
    public function parseTransaction(string $userMessage, array $categories, array $wallets, array $persons): array
    {
        $startTime = microtime(true);
        $errors = [];

        try {
            // Input validation
            if (empty(trim($userMessage))) {
                throw new Exception('User message cannot be empty.');
            }

            if (empty($this->apiKey)) {
                throw new Exception('OpenRouter API key not configured.');
            }

            // Check cache if enabled
            if ($this->enableCaching) {
                $cacheKey = $this->generateCacheKey($userMessage, $categories, $wallets, $persons);
                $cached = Cache::get($cacheKey);
                if ($cached) {
                    $cached['processing_time'] = microtime(true) - $startTime;
                    $cached['from_cache'] = true;
                    return $cached;
                }
            }

            // 1) Pre-filter and compact lists for prompt
            $catNames = array_map(fn($c) => $this->sanitizeForPrompt($c['name']), $categories);
            $walNames = array_map(fn($w) => $this->sanitizeForPrompt($w['name']), $wallets);
            $perNames = array_map(fn($p) => $this->sanitizeForPrompt($p['name']), $persons);

            $prompt = $this->buildPrompt($userMessage, $categories, $wallets, $persons, $catNames, $walNames, $perNames);

            // 2) Call OpenRouter with retries
            $responseText = $this->callOpenRouterWithRetries($prompt);

            // 3) Extract JSON text
            $jsonText = $this->extractJson($responseText);

            if ($jsonText === null) {
                Log::warning('OpenRouter returned non-JSON response', [
                    'raw' => $responseText,
                    'user_message' => $userMessage
                ]);
                throw new Exception('AI did not return valid JSON.');
            }

            // 4) Decode JSON to array
            $decoded = json_decode($jsonText, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::warning('JSON decode error', [
                    'error' => json_last_error_msg(),
                    'json' => $jsonText,
                    'user_message' => $userMessage
                ]);
                throw new Exception('Failed to decode JSON from AI: ' . json_last_error_msg());
            }

            Log::info('OpenRouter response decoded successfully', [
                'response' => $decoded
            ]);

            // 5) Validate basic schema keys and types
            $this->validateBasicSchema($decoded);

            // 6) Process and canonicalize data
            $result = $this->processAndValidateData($decoded, $categories, $wallets, $persons);

            // Add metadata
            $result['success'] = true;
            $result['processing_time'] = microtime(true) - $startTime;
            $result['errors'] = $errors;
            $result['model_used'] = $this->model;

            // Include raw response if debug logging is enabled
            if ($this->enableDebugLogging) {
                $result['raw_ai_response'] = $responseText;
            }

            // Cache the result if caching is enabled
            if ($this->enableCaching && isset($cacheKey)) {
                Cache::put($cacheKey, $result, now()->addMinutes($this->cacheMinutes));
            }

            return $result;
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            Log::error('OpenRouter transaction parsing failed', [
                'error' => $e->getMessage(),
                'user_message' => $userMessage,
                'processing_time' => microtime(true) - $startTime,
                'stack_trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'parsed_data' => null,
                'new_entries' => [
                    'categories' => [],
                    'wallets' => [],
                    'persons' => [],
                ],
                'processing_time' => microtime(true) - $startTime,
                'errors' => $errors,
                'model_used' => $this->model
            ];
        }
    }

    /**
     * Generate cache key for the request
     */
    protected function generateCacheKey(string $userMessage, array $categories, array $wallets, array $persons): string
    {
        $data = [
            'message' => $userMessage,
            'categories' => array_column($categories, 'name'),
            'wallets' => array_column($wallets, 'name'),
            'persons' => array_column($persons, 'name'),
            'model' => $this->model
        ];

        return 'openrouter_parse_' . md5(json_encode($data));
    }

    /**
     * Call OpenRouter with retry logic
     */
    protected function callOpenRouterWithRetries(string $prompt): string
    {
        $attempt = 0;
        $lastException = null;

        while ($attempt < $this->maxRetries) {
            try {
                $attempt++;
                return $this->callOpenRouter($prompt);
            } catch (Exception $e) {
                $lastException = $e;
                if ($attempt < $this->maxRetries) {
                    $waitTime = pow(2, $attempt); // Exponential backoff: 2, 4, 8 seconds
                    Log::info("OpenRouter attempt {$attempt} failed, retrying in {$waitTime} seconds", [
                        'error' => $e->getMessage()
                    ]);
                    sleep($waitTime);
                }
            }
        }

        throw $lastException ?? new Exception('All retry attempts failed');
    }

    /**
     * Process and validate the decoded data
     */
    protected function processAndValidateData(array $decoded, array $categories, array $wallets, array $persons): array
    {
        $newEntries = [
            'categories' => [],
            'wallets' => [],
            'persons' => [],
        ];

        $parsed = $decoded['parsed_data'] ?? [];
        $aiNewEntries = $decoded['new_entries'] ?? [];

        // AMOUNT: ensure numeric (if string containing commas or ₹ remove)
        $parsed['amount'] = $this->normalizeAmount($parsed['amount']);

        // CURRENCY: enforce 'INR'
        $parsed['currency'] = 'INR';

        // DATE: validate format YYYY-MM-DD or null
        $parsed['date'] = $this->normalizeDate($parsed['date']);

        // NOTES: ensure string or null
        $parsed['notes'] = $parsed['notes'] === null ? null : (string)$parsed['notes'];

        // CATEGORY: Only create new if not found - check existence first
        [$catId, $catObjOrNull] = $this->resolveCategory(
            $parsed['category'],
            $categories,
            $aiNewEntries['categories'] ?? []
        );

        $parsed['category'] = $catId;
        if ($catObjOrNull) {
            $newEntries['categories'][] = $catObjOrNull;
        }

        // WALLET: Handle wallet not found case - flag for user selection
        [$walId, $walObjOrNull, $needsWalletSelection] = $this->resolveWallet(
            $parsed['wallet'],
            $wallets
        );
        $parsed['wallet'] = $walId;
        if ($walObjOrNull) {
            $newEntries['wallets'][] = $walObjOrNull;
        }
        // Flag for wallet selection if wallet not found
        if ($needsWalletSelection) {
            $parsed['needs_wallet_selection'] = true;
            Log::info('Wallet selection required', [
                'input_wallet' => $parsed['wallet'] ?? 'null',
                'available_wallets' => array_column($wallets, 'name')
            ]);
        }

        // PERSON: Handle according to new rules - use existing, create new, or null
        [$perId, $perObjOrNull] = $this->resolvePerson(
            $parsed['person'],
            $persons,
            $aiNewEntries['persons'] ?? []
        );
        $parsed['person'] = $perId;
        if ($perObjOrNull) {
            $newEntries['persons'][] = $perObjOrNull;
        }

        // Final validation
        $this->validateFinalSchema($parsed);

        return [
            'parsed_data' => $parsed,
            'new_entries' => $newEntries,
        ];
    }

    /**
     * Enhanced resolve method that takes AI's new entries into account
     */
    protected function resolveOrCreateFromAI(string $type, $value, array $existingList, array $aiNewEntries): array
    {
        // If null or empty -> treat as null
        $val = $value === null ? '' : (string)$value;
        $norm = $this->normalizeNameForMatch($val);

        // First, check if AI already provided this as a new entry
        foreach ($aiNewEntries as $aiEntry) {
            if (isset($aiEntry['id']) && $aiEntry['id'] === $val) {
                // AI created this entry, use its definition
                return [$aiEntry['id'], $aiEntry];
            }
        }

        // Check existing entries for exact match
        foreach ($existingList as $item) {
            $itemNameNorm = $this->normalizeNameForMatch($item['name']);
            if ($itemNameNorm === $norm && $norm !== '') {
                return [$item['id'], null];
            }
        }

        // Check if this looks like a NEW_* ID that we should create
        if (str_starts_with($val, 'NEW_' . $type . '_')) {
            // Use the AI's new entry if provided, otherwise create our own
            foreach ($aiNewEntries as $aiEntry) {
                if (isset($aiEntry['id']) && $aiEntry['id'] === $val) {
                    return [$aiEntry['id'], $aiEntry];
                }
            }

            // Create from the ID pattern
            $short = substr($val, strlen('NEW_' . $type . '_'));
            $newObj = ['id' => $val, 'name' => ucfirst(str_replace('_', ' ', $short))];
            return [$val, $newObj];
        }

        // Not found anywhere, create new entry
        $short = $this->createShortName($val ?: "{$type}_unknown");
        $newId = "NEW_{$type}_{$short}";
        $newObj = ['id' => $newId, 'name' => $val ?: ucfirst(strtolower($type))];

        return [$newId, $newObj];
    }

    /**
     * Build the prompt text per user specification.
     */
    protected function buildPrompt(string $userMessage, array $categories, array $wallets, array $persons, array $catNames, array $walNames, array $perNames): string
    {
        // Build JSON-ish arrays for prompt (but we pass actual arrays in Laravel wrapper if wanted)
        $catLine = implode(', ', $catNames);
        $walLine = implode(', ', $walNames);
        $perLine = implode(', ', $perNames);

        // Inline schema exactly as requested
        $prompt = <<<PROMPT
            You are a financial transaction parser that ONLY returns valid JSON.

            TASK: Parse this expense message and return ONLY the JSON response specified below.

            USER MESSAGE: "{$this->escapeForPrompt($userMessage)}"

            AVAILABLE DATA:
            Categories: {$this->buildObjectArrayText($categories)}
            Wallets: {$this->buildObjectArrayText($wallets)}
            Persons: {$this->buildObjectArrayText($persons)}

            RULES:
            1. For category, wallet, person - match existing entries by name (case-insensitive)
            2. If no match found, create NEW entry with format: NEW_<TYPE>_<shortname>
            3. Amount must be numeric (remove currency symbols)
            4. Currency is always "INR"
            5. Date format: YYYY-MM-DD or null
            6. Person can be "Self" if referring to user

            REQUIRED JSON OUTPUT FORMAT:
            {
            "parsed_data": {
                "amount": <number>,
                "currency": "INR",
                "category": "<existing_id_or_NEW_CATEGORY_shortname>",
                "wallet": "<existing_id_or_NEW_WALLET_shortname>",
                "person": "<existing_id_or_NEW_PERSON_shortname_or_Self>",
                "notes": "<string_or_null>",
                "date": "<YYYY-MM-DD_or_null>"
            },
            "new_entries": {
                "categories": [{"id": "NEW_CATEGORY_shortname", "name": "Category Name"}],
                "wallets": [{"id": "NEW_WALLET_shortname", "name": "Wallet Name"}],
                "persons": [{"id": "NEW_PERSON_shortname", "name": "Person Name"}]
            }
            }

            RETURN ONLY VALID JSON - NO EXPLANATIONS OR EXTRA TEXT.
            PROMPT;

        return $prompt;
    }

    /**
     * Call OpenRouter and return the AI text (string).
     *
     * @throws Exception
     */
    protected function callOpenRouter(string $prompt): string
    {
        if (empty($this->apiKey)) {
            throw new Exception('OpenRouter API key not configured.');
        }

        $body = [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a precise financial data parser. Output only JSON as specified.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.0,
            'max_tokens' => 400,
        ];

        try {
            $resp = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout($this->timeoutSeconds)
                ->post($this->endpoint, $body);

            if (!$resp->ok()) {
                Log::error('OpenRouter API error', ['status' => $resp->status(), 'body' => $resp->body()]);
                throw new Exception('OpenRouter API returned HTTP ' . $resp->status());
            }

            $json = $resp->json();
            $message = data_get($json, 'choices.0.message.content') ?: data_get($json, 'choices.0.text') ?: $resp->body();
            return (string)$message;
        } catch (Exception $e) {
            Log::error('OpenRouter request failed', ['error' => $e->getMessage()]);
            throw new Exception('OpenRouter request failed: ' . $e->getMessage());
        }
    }

    /**
     * Attempt to find the first JSON object/array in a text response.
     * Returns the JSON string or null.
     */
    protected function extractJson(string $text): ?string
    {
        // Remove markdown fences if present
        $text = preg_replace('/^```(?:json)?\s*/im', '', $text);
        $text = preg_replace('/```\s*$/m', '', $text);
        $text = trim($text);

        // First try: The whole response might be valid JSON
        json_decode($text);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $text;
        }

        // Second try: Look for JSON object pattern
        if (preg_match('/\{(?:[^{}]|(?R))*\}/s', $text, $matches)) {
            $candidate = $matches[0];
            json_decode($candidate);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $candidate;
            }
        }

        // Third try: Find first { to last } and validate
        $start = strpos($text, '{');
        $end = strrpos($text, '}');

        if ($start !== false && $end !== false && $end > $start) {
            $candidate = substr($text, $start, $end - $start + 1);
            json_decode($candidate);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $candidate;
            }

            // Try progressively shrinking from the end to find valid JSON
            for ($i = $end; $i > $start; $i--) {
                if ($text[$i] === '}') {
                    $candidate = substr($text, $start, $i - $start + 1);
                    json_decode($candidate);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return $candidate;
                    }
                }
            }
        }

        // Fourth try: Look for multi-line JSON with flexible regex
        if (preg_match('/\{[\s\S]*\}/m', $text, $matches)) {
            $candidate = $matches[0];
            json_decode($candidate);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $candidate;
            }
        }

        Log::warning('Failed to extract valid JSON from AI response', [
            'response_length' => strlen($text),
            'response_preview' => substr($text, 0, 200)
        ]);

        return null;
    }

    /**
     * Very basic schema presence and type check (before canonicalization).
     * Throws Exception on failure.
     */
    protected function validateBasicSchema(array $data): void
    {
        // Check if we have the main structure
        if (!isset($data['parsed_data'])) {
            throw new Exception("Missing 'parsed_data' key in AI output");
        }

        if (!isset($data['new_entries'])) {
            throw new Exception("Missing 'new_entries' key in AI output");
        }

        $parsedData = $data['parsed_data'];
        $requiredKeys = ['amount', 'currency', 'category', 'wallet', 'person', 'notes', 'date'];

        foreach ($requiredKeys as $k) {
            if (!array_key_exists($k, $parsedData)) {
                throw new Exception("Missing required key in parsed_data: {$k}");
            }
        }

        // amount must exist (string or number ok for now)
        if (!is_numeric($parsedData['amount']) && !is_string($parsedData['amount'])) {
            throw new Exception('Amount must be numeric or numeric-string.');
        }

        // currency must be present (we will override to INR later)
        if (!is_string($parsedData['currency'])) {
            throw new Exception('Currency must be a string.');
        }

        // category/wallet/person should be string or null
        foreach (['category', 'wallet', 'person'] as $k) {
            if (!is_string($parsedData[$k]) && !is_null($parsedData[$k])) {
                throw new Exception("{$k} must be string or null.");
            }
        }

        // notes: string or null
        if (!is_string($parsedData['notes']) && !is_null($parsedData['notes'])) {
            throw new Exception("notes must be string or null.");
        }

        // date: string or null
        if (!is_string($parsedData['date']) && !is_null($parsedData['date'])) {
            throw new Exception("date must be string (YYYY-MM-DD) or null.");
        }

        // Validate new_entries structure
        $newEntries = $data['new_entries'];
        $expectedEntryTypes = ['categories', 'wallets', 'persons'];

        foreach ($expectedEntryTypes as $type) {
            if (!isset($newEntries[$type])) {
                $newEntries[$type] = []; // Set default empty array if missing
            } elseif (!is_array($newEntries[$type])) {
                throw new Exception("new_entries.{$type} must be an array.");
            }
        }

        // Update the data array reference
        $data['new_entries'] = $newEntries;
    }

    /**
     * Normalize amount into numeric (float/int).
     */
    protected function normalizeAmount($amount)
    {
        if (is_numeric($amount)) {
            return 0 + $amount;
        }

        // remove common currency symbols and separators
        $s = (string)$amount;
        $s = preg_replace('/[^\d\.\-]/u', '', $s); // keeps digits, dot, minus
        if ($s === '' || !is_numeric($s)) {
            throw new Exception('Could not parse amount from AI output.');
        }
        return 0 + $s;
    }

    /**
     * Normalize date: if valid YYYY-MM-DD return that, else null
     */
    protected function normalizeDate($date)
    {
        if ($date === null) {
            return null;
        }
        $d = trim((string)$date);
        // Accept YYYY-MM-DD only
        try {
            $c = Carbon::createFromFormat('Y-m-d', $d);
            if ($c && $c->format('Y-m-d') === $d) {
                return $d;
            }
        } catch (\Exception $e) {
            // ignore
        }
        // Try parsing natural date (e.g., "today", "yesterday", "2025/07/07")
        try {
            $c2 = Carbon::parse($d);
            return $c2->format('Y-m-d');
        } catch (\Exception $e) {
            // fallback null
        }
        return null;
    }

    /**
     * Resolve value against provided list. If found returns [id, null].
     * If not found, returns [newId, newObject].
     *
     * $type: CATEGORY | WALLET | PERSON
     * $value: string (name or id candidate)
     * $list: array of objects with id & name
     *
     * Matching rule: case-insensitive comparison of normalized names (trim spaces).
     */
    protected function resolveOrCreate(string $type, $value, array $list): array
    {
        // If null or empty -> treat as null (and create NEW with name "Unknown_<type>"? But spec says create new entry with name from message)
        $val = $value === null ? '' : (string)$value;
        $norm = $this->normalizeNameForMatch($val);

        // Attempt to find exact name match in provided list
        foreach ($list as $item) {
            $itemNameNorm = $this->normalizeNameForMatch($item['name']);
            if ($itemNameNorm === $norm && $norm !== '') {
                return [$item['id'], null];
            }
        }

        // Not found. If value is empty -> create a generic NEW_<TYPE>_unknown
        $short = $this->createShortName($val ?: "{$type}_unknown");
        $newId = "NEW_{$type}_{$short}";
        $newObj = ['id' => $newId, 'name' => $val ?: ucfirst(strtolower($type))];

        return [$newId, $newObj];
    }

    /**
     * Check strings that mean self.
     */
    protected function isSelfValue(string $s): bool
    {
        $s = strtolower(trim($s));
        return in_array($s, ['self', 'me', 'i', 'myself', 'mine']);
    }

    /**
     * Create shortname: lowercase, remove non-alphanum, limit length
     */
    protected function createShortName(string $name, int $max = 32): string
    {
        $n = strtolower($name);
        $n = preg_replace('/\s+/', '', $n);                // remove spaces
        $n = preg_replace('/[^a-z0-9]/', '', $n);          // keep only alnum
        $n = substr($n, 0, $max);
        if ($n === '') {
            $n = Str::random(6);
        }
        return $n;
    }

    /**
     * Validate final schema strictly before returning.
     */
    protected function validateFinalSchema(array $data): void
    {
        // Keys presence
        $required = ['amount', 'currency', 'category', 'wallet', 'person', 'notes', 'date'];
        foreach ($required as $k) {
            if (!array_key_exists($k, $data)) {
                throw new Exception("Final parsed_data missing required key: {$k}");
            }
        }

        if (!is_numeric($data['amount'])) {
            throw new Exception('Final amount is not numeric');
        }

        if ($data['currency'] !== 'INR') {
            throw new Exception('Currency must be INR');
        }

        // category must be non-empty string
        if (!is_string($data['category']) || trim($data['category']) === '') {
            throw new Exception("Final category must be non-empty string.");
        }

        // wallet can be null if needs_wallet_selection is true
        if (isset($data['needs_wallet_selection']) && $data['needs_wallet_selection'] === true) {
            // wallet can be null when user needs to select
            if (!is_null($data['wallet']) && (!is_string($data['wallet']) || trim($data['wallet']) === '')) {
            throw new Exception("Final wallet must be null or non-empty string when needs_wallet_selection is true.");
            }
        } else {
            // wallet must be non-empty string when not flagged for selection
            if (!is_string($data['wallet']) || trim($data['wallet']) === '') {
            throw new Exception("Final wallet must be non-empty string.");
            }
        }

        // person can be null or non-empty string (including "Self")
        if (!is_null($data['person']) && (!is_string($data['person']) || trim($data['person']) === '')) {
            throw new Exception("Final person must be null or non-empty string.");
        }

        // notes string or null
        if (!is_null($data['notes']) && !is_string($data['notes'])) {
            throw new Exception('notes must be string or null');
        }

        // date: null or YYYY-MM-DD
        if (!is_null($data['date'])) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date'])) {
                throw new Exception('date must be null or in YYYY-MM-DD format');
            }
        }
    }

    /**
     * Helper: create an array-like text representation of objects for prompt readability.
     */
    protected function buildObjectArrayText(array $objects): string
    {
        // Build JSON-like array for the prompt but not needed to be strict JSON
        $items = array_map(function ($o) {
            $id = $this->escapeForPrompt($o['id']);
            $name = $this->escapeForPrompt($o['name']);
            return "{\"id\":\"{$id}\",\"name\":\"{$name}\"}";
        }, $objects);

        return '[' . implode(', ', $items) . ']';
    }

    /**
     * Escape newlines and double quotes for prompt injection safety.
     */
    protected function escapeForPrompt(string $s): string
    {
        $s = str_replace("\r", ' ', $s);
        $s = str_replace("\n", ' ', $s);
        $s = str_replace('"', '\"', $s);
        return trim($s);
    }

    protected function sanitizeForPrompt(string $s): string
    {
        // collapse spaces and trim
        return trim(preg_replace('/\s+/', ' ', $s));
    }

    protected function normalizeNameForMatch(string $s): string
    {
        // case-insensitive, ignore extra spaces and punctuation differences
        $s = trim($s);
        $s = preg_replace('/\s+/', ' ', $s);
        $s = mb_strtolower($s);
        $s = trim($s);
        return $s;
    }

    protected function sanitizeId(string $s): string
    {
        return preg_replace('/[^A-Za-z0-9_\-]/', '_', $s);
    }

    /**
     * Resolve category - only create new if not found
     */
    protected function resolveCategory($value, array $existingList, array $aiNewEntries): array
    {
        Log::debug('Resolving category', [
            'input' => $value,
            'existing_categories' => array_column($existingList, 'name'),
            'ai_new_entries' => array_column($aiNewEntries, 'name')
        ]);

        // If null or empty -> treat as null
        $val = $value === null ? '' : (string)$value;
        $norm = $this->normalizeNameForMatch($val);

        // Check if AI already provided this as a new entry
        foreach ($aiNewEntries as $aiEntry) {
            if (isset($aiEntry['id']) && $aiEntry['id'] === $val) {
                return [$aiEntry['id'], $aiEntry];
            }
        }

        // Check existing entries for exact match
        foreach ($existingList as $existing) {
            $existingNorm = $this->normalizeNameForMatch($existing['id']);
            if ($existingNorm === $norm) {
                return [(string)$existing['id'], null];
            }
        }

        // Category not found - create new only if it doesn't exist
        if (!empty($val) && !str_starts_with($val, 'NEW_CATEGORY_')) {
            $newId = 'NEW_CATEGORY_' . $this->sanitizeId($val);
            $newObj = ['id' => $newId, 'name' => $val];
            return [$newId, $newObj];
        }

        return [$val, null];
    }

    /**
     * Resolve wallet - do not create new, flag for user selection if not found
     */
    protected function resolveWallet($value, array $existingList): array
    {
        Log::debug('Resolving wallet', [
            'input' => $value,
            'existing_wallets' => array_column($existingList, 'name')
        ]);

        // If null or empty -> flag for selection
        $val = $value === null ? '' : (string)$value;
        $norm = $this->normalizeNameForMatch($val);

        if (empty($val)) {
            Log::info('Wallet not provided, flagging for user selection');
            return [null, null, true]; // needs wallet selection
        }

        // Check existing entries for exact match
        foreach ($existingList as $existing) {
            $existingNorm = $this->normalizeNameForMatch($existing['name']);
            if ($existingNorm === $norm) {
                Log::info('Wallet matched', [
                    'input' => $val,
                    'matched' => $existing['name'],
                    'id' => $existing['id']
                ]);
                return [(string)$existing['id'], null, false];
            }
        }

        // Wallet not found - do not create, flag for user selection
        Log::info('Wallet not found, flagging for user selection', [
            'input' => $val,
            'available_wallets' => array_column($existingList, 'name')
        ]);
        
        return [null, null, true];
    }

    /**
     * Resolve person - use existing, create new if name available, or null
     */
    protected function resolvePerson($value, array $existingList, array $aiNewEntries): array
    {
        // Handle self reference
        if (is_string($value) && $this->isSelfValue($value)) {
            return ['Self', null];
        }

        // If null or empty -> set to null
        $val = $value === null ? '' : (string)$value;
        $norm = $this->normalizeNameForMatch($val);

        if (empty($val)) {
            return [null, null];
        }

        // Check if AI already provided this as a new entry
        foreach ($aiNewEntries as $aiEntry) {
            if (isset($aiEntry['id']) && $aiEntry['id'] === $val) {
                return [$aiEntry['id'], $aiEntry];
            }
        }

        // Check existing entries for exact match
        foreach ($existingList as $existing) {
            $existingNorm = $this->normalizeNameForMatch($existing['name']);
            if ($existingNorm === $norm) {
                return [(string)$existing['id'], null];
            }
        }

        // Person not found but name available - create new person
        if (!empty($val) && !str_starts_with($val, 'NEW_PERSON_')) {
            $newId = 'NEW_PERSON_' . $this->sanitizeId($val);
            $newObj = ['id' => $newId, 'name' => $val];
            return [$newId, $newObj];
        }

        // No name available - set to null
        return [null, null];
    }
}
