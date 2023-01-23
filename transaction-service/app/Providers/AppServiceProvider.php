<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Transactions\Presentation\Rest\TransactionRouter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(TransactionRouter::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
