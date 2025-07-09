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
    public function index(Request $request)
    {
        $query = Budget::where('user_id', Auth::id())->with(['category', 'histories']);

        // Search by keyword (searches category name and amount)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('category', function ($cat) use ($search) {
                    $cat->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('amount', 'like', '%' . $search . '%');
            });
        }

        // Quick filter: active or expired
        if ($request->filled('filter')) {
            if ($request->filter === 'active') {
                $query->where('end_date', '>=', now());
            } elseif ($request->filter === 'expired') {
                $query->where('end_date', '<', now());
            }
        }

        // Start date filter
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }

        // End date filter
        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Frequency filter
        if ($request->filled('frequency')) {
            $query->where('frequency', $request->frequency);
        }

        // Roll over filter
        if ($request->has('roll_over') && $request->roll_over !== '') {
            $query->where('roll_over', $request->roll_over);
        }

        $budgets = $query->orderBy('start_date', 'desc')->paginate(10)->appends($request->except('page'));

        // For the filter dropdowns
        $categories = Auth::user()->categories()->get();

        return view('budgets.index', compact('budgets', 'categories'));
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
            $budget->histories()->delete();
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
