<?php

namespace Src\Ledger\Presentation\Rest;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Src\Ledger\Presentation\Rest\Controllers\LedgerController;

class LedgerRouter extends RouteServiceProvider
{
    public function register()
    {
        Route::prefix('ledger')->name('ledger.')->group(function () {
            Route::get('/', [LedgerController::class, 'show'])->name('show');
        });
    }
}
