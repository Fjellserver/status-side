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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', 'App\Http\Controllers\Updater@hosts', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('dashboard/', 'App\Http\Controllers\UserController@formSubmit', function () {
});

Route::post('dashboard/update', 'App\Http\Controllers\Updater@hostSubmit', function () {
});

Route::post('dashboard/{id}', 'App\Http\Controllers\Updater@removehost', function () {
});