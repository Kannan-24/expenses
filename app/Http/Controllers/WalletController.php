<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Wallet::with('walletType', 'currency');

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

        $wallets = $query->paginate(10)->appends($request->only('search'));

        return view('wallets.index', compact('wallets'));
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
            'user_id' => 'required|exists:users,id',
            'wallet_type_id' => 'required|exists:wallet_types,id',
            'name' => 'required|string|max:255|unique:wallets,name,NULL,id,user_id,' . $request->user_id . ',wallet_type_id,' . $request->wallet_type_id,
            'balance' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'is_active' => 'boolean',
        ]);

        $wallet = Wallet::create([
            'user_id' => $request->input('user_id'),
            'wallet_type_id' => $request->input('wallet_type_id'),
            'name' => $request->input('name'),
            'balance' => $request->input('balance'),
            'currency_id' => $request->input('currency_id'),
            'is_active' => $request->input('is_active', true),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'wallet' => $wallet
            ]);
        }

        return redirect()->route('wallets.index')->with('success', 'Wallet created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        $wallet->load('walletType', 'currency');
        return view('wallets.show', compact('wallet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        $walletTypes = WalletType::where('is_active', true)->get();
        $currencies = Currency::all();
        return view('wallets.edit', compact('wallet', 'walletTypes', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
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
        $wallet->delete();
        return redirect()->route('wallets.index')->with('success', 'Wallet deleted successfully.');
    }
}
