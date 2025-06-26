<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
            ->with(['category', 'histories'])
            ->paginate(10);

        return view('budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Auth::user()->categories()->pluck('name', 'id');
        return view('budgets.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'roll_over' => 'boolean',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'roll_over' => $request->roll_over,
            'frequency' => $request->frequency,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        $this->authorizeUser($budget);

        $histories = $budget->histories()->orderBy('created_at', 'desc')->paginate(10);
        return view('budgets.show', compact('budget', 'histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        $this->authorizeUser($budget);

        $categories = Auth::user()->categories()->pluck('name', 'id');
        return view('budgets.edit', compact('budget', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $this->authorizeUser($budget);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'roll_over' => 'boolean',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
        ]);

        $budget->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'roll_over' => $request->roll_over,
            'frequency' => $request->frequency,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $this->authorizeUser($budget);

        if ($budget->histories()->count() > 0) {
            return redirect()->route('budgets.index')->with('error', 'Cannot delete budget with existing histories.');
        }

        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully.');
    }

    /**
     * Authorize the user can access the budget resource.
     */
    public function authorizeUser(Budget $budget)
    {
        if (Auth::user()->id !== $budget->user_id) {
            abort(403, 'Unauthorized.');
        }
    }
}
