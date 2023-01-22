<?php

namespace Src\Customer\Presentation\Rest;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Src\Customer\Presentation\Rest\Controllers\CustomerController;

class CustomerRouter extends RouteServiceProvider
{
    public function register()
    {
        Route::prefix('customer')
            ->name('customer.')
            ->middleware('api')
            ->group(function () {
                Route::post('/', [CustomerController::class, 'register'])->name('register');
            });
    }
}
