<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // CHANGED: Use withCount('products') to get the count, removed 'parent' relationship
        $query = Category::withCount('products')->latest();

        if ($search = $request->search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10);
        
        // Removed $parentCategories variable as it is no longer needed
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Removed parent_id validation
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);
        // Ensure no parent_id is accidentally set
        $data['parent_id'] = null; 

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();  
            $file->move(public_path('images'), $filename);  
            $data['image'] = 'images/' . $filename;
        }

        $category = Category::create($data);
        // No need to load 'parent' anymore

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully!',
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Removed parent_id validation
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($category->image && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['image'] = 'images/' . $filename;
        }

        $category->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!',
            'category' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->image && File::exists(public_path($category->image))) {
            File::delete(public_path($category->image));
        }
        
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!'
        ]);
    }
}