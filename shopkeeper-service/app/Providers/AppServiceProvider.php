<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Domain\Repositories\TokenRepository;
use Src\Shopkeeper\Domain\Repositories\ShopkeeperRepository;
use Src\Shopkeeper\Presentation\Rest\ShopkeeperRouter;
use Src\Infrastructure\Repositories\ShopkeeperEloquentRepository;
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
        $this->app->register(ShopkeeperRouter::class);

        $this->app->bind(ShopkeeperRepository::class, ShopkeeperEloquentRepository::class);
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
