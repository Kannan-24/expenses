<?php

namespace App\Http\Controllers;

use App\Models\ExpensePerson;
use App\Services\ExpensePersonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensePersonController extends Controller
{
    protected ExpensePersonService $expensePersonService;

    public function __construct(ExpensePersonService $expensePersonService)
    {
        $this->expensePersonService = $expensePersonService;
        $this->middleware('can:manage expense people');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $people = $this->expensePersonService->getPaginatedExpensePeople(Auth::user(), $search, 12);
        $people->appends($request->only('search'));

        return view('expense_people.index', compact('people'));
    }

    public function create()
    {
        return view('expense_people.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = Auth::user();

        // Check if expense person name is unique for this user
        if (!$this->expensePersonService->isExpensePersonNameUniqueForUser($request->name, $user)) {
            return back()->withErrors(['name' => 'A person with this name already exists.'])->withInput();
        }

        $expensePerson = $this->expensePersonService->createExpensePerson($user, $request->only(['name']));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'person' => $expensePerson,
            ]);
        }

        return redirect()->route('expense-people.index')->with('success', 'Person added successfully.');
    }

    public function edit($id)
    {
        $person = $this->expensePersonService->findExpensePersonForUser($id, Auth::user());
        
        if (!$person) {
            abort(404, 'Person not found');
        }

        return view('expense_people.edit', compact('person'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        $person = $this->expensePersonService->findExpensePersonForUser($id, $user);
        
        if (!$person) {
            abort(404, 'Person not found');
        }

        // Check if expense person name is unique for this user (excluding current person)
        if (!$this->expensePersonService->isExpensePersonNameUniqueForUser($request->name, $user, $person->id)) {
            return back()->withErrors(['name' => 'A person with this name already exists.'])->withInput();
        }

        $this->expensePersonService->updateExpensePerson($person, $request->only(['name']));

        return redirect()->route('expense-people.index')->with('success', 'Person updated successfully.');
    }

    public function destroy($id)
    {
        $person = $this->expensePersonService->findExpensePersonForUser($id, Auth::user());
        
        if (!$person) {
            abort(404, 'Person not found');
        }

        $this->expensePersonService->deleteExpensePerson($person);

        return back()->with('success', 'Person deleted.');
    }
}
