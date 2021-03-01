<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\StatusController@show', function () {
    return view('status');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', 'App\Http\Controllers\Updater@main', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->post('dashboard/', 'App\Http\Controllers\UserController@formSubmit', function () {
});

Route::middleware(['auth:sanctum', 'verified'])->post('dashboard/update', 'App\Http\Controllers\Updater@hostSubmit', function () {
});

Route::middleware(['auth:sanctum', 'verified'])->post('dashboard/host/{rank}', 'App\Http\Controllers\Updater@removehost', function () {
});

Route::middleware(['auth:sanctum', 'verified'])->post('dashboard/info/{hostid}', 'App\Http\Controllers\Updater@removeinfo', function () {
});