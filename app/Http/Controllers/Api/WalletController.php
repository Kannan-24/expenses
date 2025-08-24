<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of wallets
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $search = $request->get('search');
            $filter = $request->get('filter');
            $walletTypeId = $request->get('wallet_type_id');
            $currencyId = $request->get('currency_id');
            $perPage = min($request->get('per_page', 10), 100);

            $wallets = $this->walletService->getPaginatedWallets(
                $user,
                $search,
                $filter,
                $walletTypeId,
                $currencyId,
                $perPage
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'wallets' => $wallets->items(),
                    'pagination' => [
                        'current_page' => $wallets->currentPage(),
                        'per_page' => $wallets->perPage(),
                        'total' => $wallets->total(),
                        'last_page' => $wallets->lastPage(),
                        'has_more_pages' => $wallets->hasMorePages(),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wallets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all wallets (without pagination)
     */
    public function all(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $activeOnly = $request->boolean('active_only', false);
            $wallets = $this->walletService->getUserWallets($user, $activeOnly);

            return response()->json([
                'success' => true,
                'data' => [
                    'wallets' => $wallets
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wallets',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created wallet
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            $request->validate([
                'wallet_type_id' => 'required|exists:wallet_types,id',
                'name' => 'required|string|max:255',
                'balance' => 'required|numeric|min:0',
                'currency_id' => 'required|exists:currencies,id',
                'is_active' => 'boolean',
            ]);

            // Check if wallet name is unique for user and wallet type
            if (!$this->walletService->isWalletNameUniqueForUserAndType(
                $request->name,
                $user,
                $request->wallet_type_id
            )) {
                throw ValidationException::withMessages([
                    'name' => ['A wallet with this name already exists for this wallet type.']
                ]);
            }

            $wallet = $this->walletService->createWallet($user, [
                'wallet_type_id' => $request->wallet_type_id,
                'name' => $request->name,
                'balance' => $request->balance,
                'currency_id' => $request->currency_id,
                'is_active' => $request->input('is_active', true),
            ]);

            $wallet->load('walletType', 'currency');

            return response()->json([
                'success' => true,
                'message' => 'Wallet created successfully',
                'data' => [
                    'wallet' => $wallet
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create wallet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified wallet
     */
    public function show(int $id, Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $wallet = $this->walletService->findWalletForUser($id, $user);

            if (!$wallet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wallet not found'
                ], 404);
            }

            $includeTransactions = $request->boolean('include_transactions', false);

            if ($includeTransactions) {
                $transactionsPerPage = min($request->get('transactions_per_page', 10), 50);
                $data = $this->walletService->getWalletWithTransactions($wallet, $transactionsPerPage);
            } else {
                $data = ['wallet' => $wallet];
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wallet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified wallet
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $wallet = $this->walletService->findWalletForUser($id, $user);

            if (!$wallet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wallet not found'
                ], 404);
            }

            $request->validate([
                'wallet_type_id' => 'required|exists:wallet_types,id',
                'name' => 'required|string|max:255',
                'balance' => 'required|numeric|min:0',
                'currency_id' => 'required|exists:currencies,id',
                'is_active' => 'boolean',
            ]);

            // Check if wallet name is unique for user and wallet type (excluding current wallet)
            if (!$this->walletService->isWalletNameUniqueForUserAndType(
                $request->name,
                $user,
                $request->wallet_type_id,
                $wallet->id
            )) {
                throw ValidationException::withMessages([
                    'name' => ['A wallet with this name already exists for this wallet type.']
                ]);
            }

            $updatedWallet = $this->walletService->updateWallet($wallet, [
                'wallet_type_id' => $request->wallet_type_id,
                'name' => $request->name,
                'balance' => $request->balance,
                'currency_id' => $request->currency_id,
                'is_active' => $request->input('is_active', true),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Wallet updated successfully',
                'data' => [
                    'wallet' => $updatedWallet
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update wallet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified wallet
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $user = Auth::user();
            $wallet = $this->walletService->findWalletForUser($id, $user);

            if (!$wallet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wallet not found'
                ], 404);
            }

            // Check if wallet has transactions
            if ($this->walletService->walletHasTransactions($wallet)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete wallet with existing transactions'
                ], 409);
            }

            $this->walletService->deleteWallet($wallet);

            return response()->json([
                'success' => true,
                'message' => 'Wallet deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete wallet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Transfer funds between wallets
     */
    public function transfer(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            $request->validate([
                'from_wallet_id' => 'required|integer',
                'to_wallet_id' => 'required|integer|different:from_wallet_id',
                'amount' => 'required|numeric|min:0.01',
            ]);

            [$fromWallet, $toWallet] = $this->walletService->validateTransfer(
                $user,
                $request->from_wallet_id,
                $request->to_wallet_id
            );

            $this->walletService->transferFunds($fromWallet, $toWallet, $request->amount);

            return response()->json([
                'success' => true,
                'message' => 'Transfer completed successfully',
                'data' => [
                    'from_wallet' => $fromWallet->fresh(),
                    'to_wallet' => $toWallet->fresh(),
                    'amount' => $request->amount
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transfer failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get wallet statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $user = Auth::user();
            $stats = $this->walletService->getWalletStats($user);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wallet statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get balance summary by currency
     */
    public function balanceSummary(): JsonResponse
    {
        try {
            $user = Auth::user();
            $summary = $this->walletService->getBalanceSummaryByCurrency($user);

            return response()->json([
                'success' => true,
                'data' => [
                    'balance_summary' => $summary
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve balance summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get wallets by currency
     */
    public function byCurrency(int $currencyId): JsonResponse
    {
        try {
            $user = Auth::user();
            $wallets = $this->walletService->getWalletsByCurrency($user, $currencyId);

            return response()->json([
                'success' => true,
                'data' => [
                    'wallets' => $wallets
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wallets by currency',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get wallet types for dropdowns
     */
    public function walletTypes(): JsonResponse
    {
        try {
            $walletTypes = $this->walletService->getActiveWalletTypes();

            return response()->json([
                'success' => true,
                'data' => [
                    'wallet_types' => $walletTypes
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve wallet types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get currencies for dropdowns
     */
    public function currencies(): JsonResponse
    {
        try {
            $currencies = $this->walletService->getAllCurrencies();

            return response()->json([
                'success' => true,
                'data' => [
                    'currencies' => $currencies
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve currencies',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
