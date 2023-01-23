<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Infrastructure\Repositories\TransactionableEloquentRepository;
use Src\Infrastructure\Repositories\TransactionEloquentRepository;
use Src\Transactionables\Domain\Repositories\TransactionableRepository;
use Src\Transactionables\Presentation\TransactionableRouter;
use Src\Transactions\Domain\Repositories\TransactionRepository;
use Src\Transactions\Presentation\Rest\TransactionRouter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(TransactionRouter::class);
        $this->app->register(TransactionableRouter::class);

        $this->app->bind(TransactionableRepository::class, TransactionableEloquentRepository::class);
        $this->app->bind(TransactionRepository::class, TransactionEloquentRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
