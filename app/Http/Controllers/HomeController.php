<?php

namespace App\Http\Controllers;

use Application\Services\ShoeService;
use Application\Services\CategoryService;
use App\Models\Banner;

class HomeController extends Controller
{
    public function __construct(
        private ShoeService $shoeService,
        private CategoryService $categoryService
    ) {}

    public function index()
    {
        $featuredShoes = $this->shoeService->getFeaturedShoes(8);
        $categories = $this->categoryService->getActiveCategories();
        $banners = Banner::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('home', compact('featuredShoes', 'categories', 'banners'));
    }
}
