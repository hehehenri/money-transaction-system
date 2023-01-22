<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Customer\Presentation\Rest\CustomerRouter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(CustomerRouter::class);
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
