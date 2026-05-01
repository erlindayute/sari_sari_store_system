<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Auth
|--------------------------------------------------------------------------
|
| Base URL: /api
|
| Public routes   → no middleware
| Protected routes → auth:sanctum middleware
|
*/

// ── Public ────────────────────────────────────────────────────────────────────
Route::prefix('auth')->name('auth.')->group(function () {

    // POST /api/auth/register
    Route::post('register', [AuthController::class, 'register'])
        ->name('register');

    // POST /api/auth/login
    Route::post('login', [AuthController::class, 'login'])
        ->name('login');
});

// ── Protected (requires valid Sanctum token) ──────────────────────────────────
Route::prefix('auth')->name('auth.')->middleware('auth:sanctum')->group(function () {

    // POST /api/auth/logout
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');

    // GET /api/auth/me
    Route::get('me', [AuthController::class, 'me'])
        ->name('me');
});
