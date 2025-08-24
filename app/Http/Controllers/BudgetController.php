<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Services\BudgetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    protected $budgetService;

    public function __construct(BudgetService $budgetService)
    {
        $this->middleware('auth');
        $this->middleware('can:manage budgets');
        $this->budgetService = $budgetService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'filter', 'start_date', 'end_date', 'category', 'frequency', 'roll_over']);
        
        $budgets = $this->budgetService->getPaginatedBudgets(Auth::id(), $filters, 10);
        $categories = $this->budgetService->getUserCategories(Auth::id());

        // Attach filter values to the pagination links
        $budgets->appends($request->except('page'));

        return view('budgets.index', compact('budgets', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->budgetService->getUserCategories(Auth::id())->pluck('name', 'id');
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

        try {
            $this->budgetService->createBudget(Auth::id(), $request->all());
            return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        try {
            $this->budgetService->validateOwnership($budget, Auth::id());
            $data = $this->budgetService->getBudgetWithHistories($budget, 10);
            return view('budgets.show', $data);
        } catch (\Exception $e) {
            abort(403, 'Unauthorized.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        try {
            $this->budgetService->validateOwnership($budget, Auth::id());
            $categories = $this->budgetService->getUserCategories(Auth::id())->pluck('name', 'id');
            return view('budgets.edit', compact('budget', 'categories'));
        } catch (\Exception $e) {
            abort(403, 'Unauthorized.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'roll_over' => 'boolean',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
        ]);

        try {
            $this->budgetService->validateOwnership($budget, Auth::id());
            $this->budgetService->updateBudget($budget, $request->all());
            return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        try {
            $this->budgetService->validateOwnership($budget, Auth::id());
            $this->budgetService->deleteBudget($budget);
            return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
