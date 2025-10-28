<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tetap pakai Bootstrap 5 untuk pagination
        Paginator::useBootstrapFive();

        // Tambahan: kirim jumlah cart ke semua view
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check() && Auth::user()->role === 'user') {
                $cart = Cart::where('user_id', Auth::id())->first();

                if ($cart) {
                    $cartCount = $cart->cartItems()->sum('quantity');
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
