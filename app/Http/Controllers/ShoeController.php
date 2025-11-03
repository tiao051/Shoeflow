<?php

namespace App\Http\Controllers;

use Application\Services\ShoeService;
use Application\Services\CategoryService;
use Application\Services\ReviewService;
use Illuminate\Http\Request;

class ShoeController extends Controller
{
    public function __construct(
        private ShoeService $shoeService,
        private CategoryService $categoryService,
        private ReviewService $reviewService
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'category_id' => $request->get('category'),
            'brand' => $request->get('brand'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'size' => $request->get('size'),
            'sort' => $request->get('sort', 'newest'),
        ];

        $shoes = $this->shoeService->searchShoes($filters, 12);
        $categories = $this->categoryService->getActiveCategories();
        $brands = $this->shoeService->getAvailableBrands();
        $sizes = $this->shoeService->getAvailableSizes();

        return view('shoes.index', compact('shoes', 'categories', 'brands', 'sizes', 'filters'));
    }

    public function show(string $slug)
    {
        $shoe = $this->shoeService->getShoeBySlug($slug);
        
        if (!$shoe) {
            abort(404, 'Shoe not found');
        }

        $reviews = $this->reviewService->getShoeReviews($shoe['id']);
        
        return view('shoes.show', compact('shoe', 'reviews'));
    }

    public function category(string $categorySlug, Request $request)
    {
        $category = $this->categoryService->getCategoryBySlug($categorySlug);
        
        if (!$category) {
            abort(404, 'Category not found');
        }

        $filters = [
            'category_id' => $category['id'],
            'search' => $request->get('search'),
            'brand' => $request->get('brand'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'size' => $request->get('size'),
            'sort' => $request->get('sort', 'newest'),
        ];

        $shoes = $this->shoeService->searchShoes($filters, 12);
        $brands = $this->shoeService->getAvailableBrands();
        $sizes = $this->shoeService->getAvailableSizes();

        return view('shoes.category', compact('category', 'shoes', 'brands', 'sizes', 'filters'));
    }
}
