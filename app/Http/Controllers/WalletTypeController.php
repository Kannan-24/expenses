<?php

namespace App\Http\Controllers;

use App\Models\WalletType;
use Illuminate\Http\Request;

class WalletTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage wallet types');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WalletType::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        $walletTypes = $query->orderBy('name')->paginate(10)->appends($request->except('page'));

        return view('wallet_types.index', compact('walletTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wallet_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:wallet_types,name',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        WalletType::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active', true),
        ]);

        return redirect()->route('wallet-types.index')->with('success', 'Wallet Type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WalletType $walletType)
    {
        return view('wallet_types.edit', compact('walletType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WalletType $walletType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:wallet_types,name,' . $walletType->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $walletType->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_active' => $request->input('is_active') ? true : false,
        ]);

        return redirect()->route('wallet-types.index')->with('success', 'Wallet Type updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WalletType $walletType)
    {
        return view('wallet_types.show', compact('walletType'));
    }

    /**
     * Remove the specified resource from storage temproarily.
     */
    public function destroy(WalletType $walletType)
    {
        $walletType->delete();
        return redirect()->route('wallet_types.index')->with('success', 'Wallet Type deleted successfully.');
    }
}
