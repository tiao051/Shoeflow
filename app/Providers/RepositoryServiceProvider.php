<?php

namespace App\Providers;

use Domain\Repositories\CategoryRepositoryInterface;
use Domain\Repositories\ShoeRepositoryInterface;
use Domain\Repositories\OrderRepositoryInterface;
use Domain\Repositories\ReviewRepositoryInterface;
use Domain\Repositories\PromotionRepositoryInterface;
use Infrastructure\Repositories\CategoryRepository;
use Infrastructure\Repositories\ShoeRepository;
use Infrastructure\Repositories\OrderRepository;
use Infrastructure\Repositories\ReviewRepository;
use Infrastructure\Repositories\PromotionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ShoeRepositoryInterface::class, ShoeRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(PromotionRepositoryInterface::class, PromotionRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
