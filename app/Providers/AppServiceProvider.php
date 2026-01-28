<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Membagi data saldo ke semua view yang punya komponen header/nav
        view()->composer('*', function ($view) {
            $lastBalance = \App\Models\CashLedger::latest('id')->value('current_balance') ?? 0;
            $view->with('global_closing_balance', $lastBalance);
        });
    }
}
