<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\Auth; 
use App\Models\Cart; 

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $count = 0;
            if (Auth::check()) {
                $user = Auth::user();
                $cart = Cart::where('user_id', $user->id)->first();
                if ($cart) {
                    $count = $cart->items()->sum('quantity');
                }
            }
            $view->with('cartCount', $count);
        });
    }
}