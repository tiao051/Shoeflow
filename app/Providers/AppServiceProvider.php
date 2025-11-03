<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Application\Services\ShoeService;
use Application\Services\CategoryService;
use Application\Services\CartService;
use Application\Services\OrderService;
use Application\Services\ReviewService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register service bindings for dependency injection
        $this->app->bind(ShoeService::class, ShoeService::class);
        $this->app->bind(CategoryService::class, CategoryService::class);
        $this->app->bind(CartService::class, CartService::class);
        $this->app->bind(OrderService::class, OrderService::class);
        $this->app->bind(ReviewService::class, ReviewService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
