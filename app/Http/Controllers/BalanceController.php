<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Balance;
use App\Models\BalanceHistory;

class BalanceController extends Controller
{
    // Show the edit form for balance
    public function edit()
    {
        $user = Auth::user();
        $balance = Balance::firstOrCreate(['user_id' => $user->id], [
            'cash' => 0,
            'bank' => 0,
        ]);

        return view('balance.edit', compact('balance'));
    }

    // Update balance and log history
    public function update(Request $request)
    {
        $request->validate([
            'cash' => 'required|numeric|min:0',
            'bank' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $balance = Balance::firstOrCreate(['user_id' => $user->id]);

        // Save history
        BalanceHistory::create([
            'user_id'     => $user->id,
            'updated_by'  => $user->id,
            'cash_before' => $balance->cash,
            'cash_after'  => $request->cash,
            'bank_before' => $balance->bank,
            'bank_after'  => $request->bank,
        ]);

        $balance->update([
            'cash' => $request->cash,
            'bank' => $request->bank,
        ]);

        return redirect()->route('dashboard')->with('success', 'Balance updated successfully.');
    }

    public function index(Request $request)
    {
        $query = BalanceHistory::with('editor')
            ->where('user_id', Auth::id());

        // Filter by predefined ranges
        if ($request->filter) {
            if ($request->filter === '7days') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($request->filter === '15days') {
                $query->where('created_at', '>=', now()->subDays(15));
            } elseif ($request->filter === '1month') {
                $query->where('created_at', '>=', now()->subMonth());
            }
        }

        // Filter by custom date range
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $histories = $query->orderByDesc('created_at')->paginate(9)->withQueryString();

        return view('balance.index', compact('histories'));
    }
}
