<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Models\Product;
use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('welcome')
        : view('welcome');
});

Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard/register', function () {
    return view('dashboard.register');
})->name('register');

Route::post('/dashboard/register', [AuthController::class, 'register']);

Route::get('/dashboard/login', function () {
    return view('dashboard.login');
})->name('login');

Route::post('/dashboard/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('inventory', ProductController::class)->except(['show', 'destroy']);
});
