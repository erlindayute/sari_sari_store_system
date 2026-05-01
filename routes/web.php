<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Dashboard/register', function () {
    return view('dashboard.register');
})->name('register');

Route::post('/Dashboard/register', [AuthController::class, 'register']);

Route::get('/Dashboard/login', function () {
    return view('dashboard.login');
})->name('login');

Route::post('/Dashboard/login', [AuthController::class, 'login']);
