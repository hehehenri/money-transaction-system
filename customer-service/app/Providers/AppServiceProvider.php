<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Domain\Repositories\TokenRepository;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Customer\Presentation\Rest\CustomerRouter;
use Src\Infrastructure\Repositories\CustomerEloquentRepository;
use Src\Infrastructure\Repositories\TokenEloquentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(CustomerRouter::class);

        $this->app->bind(CustomerRepository::class, CustomerEloquentRepository::class);
        $this->app->bind(TokenRepository::class, TokenEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
