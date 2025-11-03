<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Application\Services\ShoeService;
use Application\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShoeController extends Controller
{
    public function __construct(
        private ShoeService $shoeService,
        private CategoryService $categoryService
    ) {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'category_id' => $request->get('category'),
        ];

        $shoes = $this->shoeService->searchShoes($filters, 15);
        $categories = $this->categoryService->getAllCategories();

        return view('admin.shoes.index', compact('shoes', 'categories', 'filters'));
    }

    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        $brands = $this->shoeService->getAvailableBrands();
        $sizes = $this->shoeService->getAvailableSizes();

        return view('admin.shoes.create', compact('categories', 'brands', 'sizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'required|string|max:100',
            'material' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'sizes' => 'required|array',
            'stock' => 'required|integer|min:0',
            'main_image' => 'nullable|image|max:2048',
            'color' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('shoes', 'public');
        }

        $this->shoeService->createShoe($validated);

        return redirect()->route('admin.shoes.index')
            ->with('success', 'Shoe created successfully');
    }

    public function edit(int $id)
    {
        $shoe = \App\Models\Shoe::findOrFail($id);
        $categories = $this->categoryService->getAllCategories();
        $brands = $this->shoeService->getAvailableBrands();
        $sizes = $this->shoeService->getAvailableSizes();

        return view('admin.shoes.edit', compact('shoe', 'categories', 'brands', 'sizes'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'required|string|max:100',
            'material' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'sizes' => 'required|array',
            'stock' => 'required|integer|min:0',
            'main_image' => 'nullable|image|max:2048',
            'color' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('shoes', 'public');
        }

        $this->shoeService->updateShoe($id, $validated);

        return redirect()->route('admin.shoes.index')
            ->with('success', 'Shoe updated successfully');
    }

    public function destroy(int $id)
    {
        $this->shoeService->deleteShoe($id);

        return redirect()->route('admin.shoes.index')
            ->with('success', 'Shoe deleted successfully');
    }
}
