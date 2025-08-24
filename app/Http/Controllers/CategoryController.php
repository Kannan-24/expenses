<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{   
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('can:manage categories');
    }

    public function index()
    {
        $search = request('search');
        $categories = $this->categoryService->getPaginatedCategories(Auth::user(), $search, 10);
        $categories->appends(request()->except('page'));

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Check if category name is unique for this user
        if (!$this->categoryService->isCategoryNameUniqueForUser($request->name, $user)) {
            return back()->withErrors(['name' => 'A category with this name already exists.'])->withInput();
        }

        $category = $this->categoryService->createCategory($user, $request->only(['name']));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        }

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
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Check if category name is unique for this user (excluding current category)
        if (!$this->categoryService->isCategoryNameUniqueForUser($request->name, $user, $category->id)) {
            return back()->withErrors(['name' => 'A category with this name already exists.'])->withInput();
        }

        $this->categoryService->updateCategory($category, $request->only(['name']));

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);

        $this->categoryService->deleteCategory($category);
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }

    private function authorizeCategory(Category $category)
    {
        if (!$this->categoryService->categoryBelongsToUser($category, Auth::user())) {
            abort(403, 'Unauthorized');
        }
    }
}
