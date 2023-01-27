<?php

namespace Src\Transactions\Presentation\Rest;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Src\Transactions\Presentation\Rest\Controllers\TransactionController;

class TransactionRouter extends RouteServiceProvider
{
    public function register(): void
    {
        Route::name('transaction.')->prefix('transaction')->group(function () {
            Route::get('/', [TransactionController::class, 'list'])->name('list');
            Route::post('/', [TransactionController::class, 'store'])->name('store');
        });
    }
}
