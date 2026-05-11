<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UtangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\API\InventoryController;
use Illuminate\Support\Facades\Route;

/* ── Public routes ── */

Route::get('/', fn() => redirect()->route('dashboard'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register',        [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',        [AuthController::class, 'register']);
    Route::get('/login',           [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',           [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password',  [AuthController::class, 'resetPassword'])->name('password.update');
});

/* ── Authenticated routes ── */
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Inventory
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/',                          [InventoryController::class, 'index'])->name('index');
        Route::post('/',                         [InventoryController::class, 'store'])->name('store');
        Route::put('/{product}',                 [InventoryController::class, 'update'])->name('update');
        Route::delete('/{product}',              [InventoryController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/adjust-stock',   [InventoryController::class, 'adjustStock'])->name('adjust');
        // Route::get('/export/csv',                [InventoryController::class, 'exportCsv'])->name('export');
    });

    // POS
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/',          [PosController::class, 'index'])->name('index');
        Route::post('/checkout', [PosController::class, 'checkout'])->name('checkout');
        Route::get('/receipt/{transaction}', [PosController::class, 'receipt'])->name('receipt');
    });

    // Reports (manager+ only)
    Route::prefix('reports')->name('reports.')->middleware('can_access:reports')->group(function () {
        Route::get('/',           [ReportsController::class, 'index'])->name('index');
        Route::get('/export/csv', [ReportsController::class, 'exportCsv'])->name('export');
    });

    // Utang
    Route::prefix('utang')->name('utang.')->group(function () {
        Route::get('/',                    [UtangController::class, 'index'])->name('index');
        Route::post('/',                   [UtangController::class, 'store'])->name('store');
        Route::post('/{entry}/payment',    [UtangController::class, 'recordPayment'])->name('payment');
        Route::delete('/{entry}',          [UtangController::class, 'destroy'])->name('destroy');
        Route::get('/export/csv',          [UtangController::class, 'exportCsv'])->name('export');
    });

    // Users (owner only)
    Route::prefix('users')->name('users.')->middleware('can_access:users')->group(function () {
        Route::get('/',              [UserController::class, 'index'])->name('index');
        Route::post('/invite',       [UserController::class, 'invite'])->name('invite');
        Route::put('/{user}/role',   [UserController::class, 'updateRole'])->name('role');
        Route::delete('/{user}',     [UserController::class, 'destroy'])->name('destroy');
    });

    // Settings (owner only)
    Route::prefix('settings')->name('settings.')->middleware('can_access:settings')->group(function () {
        Route::get('/',        [SettingsController::class, 'index'])->name('index');
        Route::put('/store',   [SettingsController::class, 'updateStore'])->name('store');
        Route::put('/account', [SettingsController::class, 'updateAccount'])->name('account');
    });

    // Password update (all authenticated users)
    Route::post('/password', [PasswordController::class, 'update'])->name('password.change');
});
