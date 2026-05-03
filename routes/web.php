<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/Dashboard/register', function () {
    return view('dashboard.register');
})->name('register');

Route::post('/Dashboard/register', [AuthController::class, 'register']);

Route::get('/Dashboard/login', function () {
    return view('dashboard.login');
})->name('login');

Route::post('/Dashboard/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
