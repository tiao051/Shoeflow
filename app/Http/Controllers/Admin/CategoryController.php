<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Application\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $categories = $this->categoryService->paginateCategories(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $this->categoryService->createCategory($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(int $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $this->categoryService->updateCategory($id, $validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(int $id)
    {
        $this->categoryService->deleteCategory($id);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
