<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletType;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
        $this->middleware('can:manage wallets');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');
        $walletType = $request->input('wallet_type');
        $currency = $request->input('currency');

        $wallets = $this->walletService->getPaginatedWallets(
            Auth::user(),
            $search,
            $filter,
            $walletType,
            $currency,
            10
        );

        $wallets->appends($request->except('page'));

        // For filter dropdowns
        $walletTypes = $this->walletService->getActiveWalletTypes();
        $currencies = $this->walletService->getAllCurrencies();

        return view('wallets.index', compact('wallets', 'walletTypes', 'currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $walletTypes = $this->walletService->getActiveWalletTypes();
        $currencies = $this->walletService->getAllCurrencies();
        return view('wallets.create', compact('walletTypes', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'wallet_type_id' => 'required|exists:wallet_types,id',
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'is_active' => 'boolean',
        ]);

        $user = Auth::user();

        // Check if wallet name is unique for user and wallet type
        if (!$this->walletService->isWalletNameUniqueForUserAndType(
            $request->name,
            $user,
            $request->wallet_type_id
        )) {
            return redirect()->back()
                ->withErrors(['name' => 'A wallet with this name already exists for this wallet type.'])
                ->withInput();
        }

        $wallet = $this->walletService->createWallet($user, [
            'wallet_type_id' => $request->wallet_type_id,
            'name' => $request->name,
            'balance' => $request->balance,
            'currency_id' => $request->currency_id,
            'is_active' => $request->input('is_active', true),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'wallet' => $wallet->load('walletType', 'currency'),
            ]);
        }

        return redirect()->route('wallets.index')->with('success', 'Wallet created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        $this->authorizeWallet($wallet);

        $data = $this->walletService->getWalletWithTransactions($wallet, 10);

        return view('wallets.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        $this->authorizeWallet($wallet);

        $walletTypes = $this->walletService->getActiveWalletTypes();
        $currencies = $this->walletService->getAllCurrencies();
        return view('wallets.edit', compact('wallet', 'walletTypes', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        $this->authorizeWallet($wallet);

        $request->validate([
            'wallet_type_id' => 'required|exists:wallet_types,id',
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'is_active' => 'boolean',
        ]);

        $user = Auth::user();

        // Check if wallet name is unique for user and wallet type (excluding current wallet)
        if (!$this->walletService->isWalletNameUniqueForUserAndType(
            $request->name,
            $user,
            $request->wallet_type_id,
            $wallet->id
        )) {
            return redirect()->back()
                ->withErrors(['name' => 'A wallet with this name already exists for this wallet type.'])
                ->withInput();
        }

        $this->walletService->updateWallet($wallet, [
            'wallet_type_id' => $request->wallet_type_id,
            'name' => $request->name,
            'balance' => $request->balance,
            'currency_id' => $request->currency_id,
            'is_active' => $request->input('is_active', true),
        ]);

        return redirect()->route('wallets.index')->with('success', 'Wallet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        $this->authorizeWallet($wallet);

        if ($this->walletService->walletHasTransactions($wallet)) {
            return redirect()->back()->withErrors(['wallet' => 'Cannot delete wallet with existing transactions.']);
        }

        $this->walletService->deleteWallet($wallet);
        return redirect()->route('wallets.index')->with('success', 'Wallet deleted successfully.');
    }

    public function authorizeWallet(Wallet $wallet)
    {
        if (!$this->walletService->walletBelongsToUser($wallet, Auth::user())) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for transferring funds between wallets.
     */
    public function showTransferForm()
    {
        $wallets = $this->walletService->getUserWallets(Auth::user(), true);
        return view('wallets.transfer', compact('wallets'));
    }

    /**
     * Transfer funds between user's own wallets.
     */
    public function transfer(Request $request)
    {
        $request->validate([
            'from_wallet_id' => 'required|exists:wallets,id',
            'to_wallet_id' => 'required|exists:wallets,id|different:from_wallet_id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        try {
            $user = Auth::user();
            [$fromWallet, $toWallet] = $this->walletService->validateTransfer(
                $user,
                $request->from_wallet_id,
                $request->to_wallet_id
            );

            $this->walletService->transferFunds($fromWallet, $toWallet, $request->amount);

            return redirect()->route('wallets.index')->with('success', 'Transfer completed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['amount' => $e->getMessage()]);
        }
    }
}
