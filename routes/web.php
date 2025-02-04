<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Models\Shop;

Route::get('/', function () {
    return view('welcome');
});


// Route::group(['middleware' => 'guest'], function () {
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');

Route::post('auth/register', [AuthController::class, 'doRegister'])->name('doRegister');
Route::post('auth/login', [AuthController::class, 'doLogin'])->name('doLogin');
// });


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', HomeController::class)->name('dashboard');

    Route::post('shop', [ShopController::class, 'store'])->name('shop.store');

    Route::domain('{shop}.domaine.xxx')->group(function () {
        // Route::get('/show', [ShopController::class, 'show']);
    });
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
