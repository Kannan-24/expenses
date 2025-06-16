<?php

namespace App\Http\Controllers;

use App\Models\ExpensePerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensePersonController extends Controller
{
    public function index()
    {
        $people = ExpensePerson::where('user_id', Auth::id())->paginate(10);
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

        ExpensePerson::create([
            'user_id' => Auth::id(),
            'name' => $request->name
        ]);

        return redirect()->route('expense-people.index')->with('success', 'Person added successfully.');
    }

    public function edit($id)
    {
        $person = ExpensePerson::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('expense_people.edit', compact('person'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $person = ExpensePerson::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $person->update(['name' => $request->name]);

        return redirect()->route('expense-people.index')->with('success', 'Person updated successfully.');
    }

    public function destroy($id)
    {
        $person = ExpensePerson::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $person->delete();

        return back()->with('success', 'Person deleted.');
    }
}
