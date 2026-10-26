<?php

namespace App\Providers;

use App\Models\StockTransaction;
use App\Observers\StockTransactionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoginResponseContract::class, LoginResponse::class);
    }

    public function boot(): void
    {
        StockTransaction::observe(StockTransactionObserver::class);
    }
}
