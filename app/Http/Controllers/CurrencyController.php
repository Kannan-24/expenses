<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();
        return view('currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code',
            'symbol' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
        ]);

        Currency::create([
            'code' => $request->input('code'),
            'symbol' => $request->input('symbol'),
            'name' => $request->input('name'),
        ]);

        return redirect()->route('currencies.index')->with('success', 'Currency created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'symbol' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
        ]);

        $currency->update([
            'code' => $request->input('code'),
            'symbol' => $request->input('symbol'),
            'name' => $request->input('name'),
        ]);

        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
