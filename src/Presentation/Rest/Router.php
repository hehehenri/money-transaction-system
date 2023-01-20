<?php

namespace Src\Presentation\Rest;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Src\Presentation\Rest\Controllers\HealthCheckController;

class Router extends RouteServiceProvider
{
    public function register(): void
    {
        Route::prefix('/v1')->middleware('api')->group(function () {
            Route::get('/health-check', HealthCheckController::class)->name('health-check');
        });
    }
}
