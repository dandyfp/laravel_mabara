<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\GameSessionRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\CashLedgerRepositoryInterface;
use App\Repositories\Eloquent\GameSessionRepository;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\Eloquent\CashLedgerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            GameSessionRepositoryInterface::class,
            GameSessionRepository::class
        );

        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );

        $this->app->bind(
            CashLedgerRepositoryInterface::class,
            CashLedgerRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
