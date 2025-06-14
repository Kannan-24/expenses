<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,' . auth()->id(),
        ]);

        Category::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    public function edit(Category $category)
    {
        $this->authorizeCategory($category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeCategory($category);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . ',id,user_id,' . auth()->id(),
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }

    private function authorizeCategory(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
