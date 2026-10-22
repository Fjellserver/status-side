<?php

use App\Http\Controllers\StatusController;
use App\Http\Controllers\Updater;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| The public status page is open to everyone. Everything under /dashboard
| requires an authenticated session.
|
*/

Route::get('/', [StatusController::class, 'show'])->name('status');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [Updater::class, 'main'])->name('dashboard');
    Route::get('/dashboard/hostedit', [Updater::class, 'hostEditShow'])->name('hostedit');

    Route::post('/dashboard', [UserController::class, 'formSubmit'])->name('info.store');
    Route::post('/dashboard/update', [Updater::class, 'hostSubmit'])->name('host.store');
    Route::post('/dashboard/hostedit/update', [Updater::class, 'hostEdit'])->name('host.update');

    Route::post('/dashboard/host/{host}', [Updater::class, 'removehost'])
        ->whereNumber('host')
        ->name('host.destroy');
    Route::post('/dashboard/info/{info}', [Updater::class, 'removeinfo'])
        ->whereNumber('info')
        ->name('info.destroy');
});
