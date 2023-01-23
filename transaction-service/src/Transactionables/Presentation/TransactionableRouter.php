<?php

namespace Src\Transactionables\Presentation;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Src\Transactionables\Presentation\Controllers\TransactionableController;

class TransactionableRouter extends RouteServiceProvider
{
    public function register(): void
    {
        Route::name('transactionable.')->prefix('transactionable')->group(function () {
            Route::post('register', [TransactionableController::class, 'register'])->name('register');
        });
    }
}
