<?php

namespace Src\Customer\Presentation\Rest;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Src\Customer\Presentation\Rest\Controllers\CustomerAuthController;

class CustomerRouter extends RouteServiceProvider
{
    public function register()
    {
        Route::prefix('customer')->name('customer.')->middleware('api')->group(function () {
            Route::prefix('auth')->name('auth.')->group(function () {
                Route::post('/register', [CustomerAuthController::class, 'register'])->name('register');
                Route::post('/login', [CustomerAuthController::class, 'login'])->name('login');
            });
        });
    }
}
