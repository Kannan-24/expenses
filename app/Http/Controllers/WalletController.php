<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Wallet::with('walletType', 'currency')->where('user_id', Auth::id());

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('walletType', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('currency', function ($q3) use ($search) {
                        $q3->where('code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        // Quick filter: active/inactive
        if ($request->filled('filter')) {
            if ($request->filter === 'active') {
                $query->where('is_active', true);
            } elseif ($request->filter === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Wallet type filter
        if ($walletType = $request->input('wallet_type')) {
            $query->where('wallet_type_id', $walletType);
        }

        // Currency filter
        if ($currency = $request->input('currency')) {
            $query->where('currency_id', $currency);
        }

        $wallets = $query->paginate(10)->appends($request->except('page'));

        // For filter dropdowns
        $walletTypes = WalletType::where('is_active', true)->get();
        $currencies = Currency::all();

        return view('wallets.index', compact('wallets', 'walletTypes', 'currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $walletTypes = WalletType::where('is_active', true)->get();
        $currencies = Currency::all();
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

        // Check if a wallet with the same name already exists for the user and wallet type
        $existingWallet = Wallet::where('user_id', Auth::id())
            ->where('wallet_type_id', $request->input('wallet_type_id'))
            ->where('name', $request->input('name'));

        if ($existingWallet->exists()) {
            return redirect()->back()->withErrors(['name' => 'A wallet with this name already exists for this wallet type.'])
                ->withInput();
        }

        $wallet = Wallet::create([
            'user_id' => Auth::id(),
            'wallet_type_id' => $request->input('wallet_type_id'),
            'name' => $request->input('name'),
            'balance' => $request->input('balance'),
            'currency_id' => $request->input('currency_id'),
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

        $wallet->load('walletType', 'currency', 'transactions.category'); // eager load category if needed

        // Optionally, paginate transactions
        $transactions = $wallet->transactions()->latest()->paginate(10);

        return view('wallets.show', compact('wallet', 'transactions'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        $this->authorizeWallet($wallet);

        $walletTypes = WalletType::where('is_active', true)->get();
        $currencies = Currency::all();
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
            'name' => 'required|string|max:255|unique:wallets,name,' . $wallet->id . ',id,user_id,' . $wallet->user_id . ',wallet_type_id,' . $request->wallet_type_id,
            'balance' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'is_active' => 'boolean',
        ]);


        $wallet->update([
            'wallet_type_id' => $request->input('wallet_type_id'),
            'name' => $request->input('name'),
            'balance' => $request->input('balance'),
            'currency_id' => $request->input('currency_id'),
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

        $transactions = Transaction::where('wallet_id', $wallet->id)->count();

        if ($transactions > 0) {
            return redirect()->back()->withErrors(['wallet' => 'Cannot delete wallet with existing transactions.']);
        }

        $wallet->delete();
        return redirect()->route('wallets.index')->with('success', 'Wallet deleted successfully.');
    }

    public function authorizeWallet(Wallet $wallet)
    {
        if ($wallet->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
