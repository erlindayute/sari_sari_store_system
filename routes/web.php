<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UtangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PasswordController;        // ← dedicated password controller
use App\Http\Controllers\API\InventoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROOT — redirect to dashboard (or login if unauthenticated)
| The 'home' name is what Laravel uses internally after login
| (configured in RouteServiceProvider or via redirectTo())
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('home'))->name('welcome');

/*
|--------------------------------------------------------------------------
| GUEST-ONLY routes (redirects to 'home' if already logged in)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // ── Register ──────────────────────────────────────────────
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // ── Login ─────────────────────────────────────────────────
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // ── Password reset flow ───────────────────────────────────
    // FIXED: was pointing to AuthController — now uses dedicated PasswordController
    // All 4 named routes that Laravel / Blade helpers expect:
    //   password.request  →  show the "forgot?" form
    //   password.email    →  send the reset link
    //   password.reset    →  show the "set new password" form
    //   password.update   →  save the new password
    Route::get(
        '/forgot-password',
        [PasswordController::class, 'showForgot']
    )->name('password.request');

    Route::post(
        '/forgot-password',
        [PasswordController::class, 'sendResetLink']
    )->name('password.email');

    Route::get(
        '/reset-password/{token}',
        [PasswordController::class, 'showReset']
    )->name('password.reset');

    Route::post(
        '/reset-password',
        [PasswordController::class, 'resetPassword']
    )->name('password.update');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ── Logout ────────────────────────────────────────────────
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ── Dashboard / Home ──────────────────────────────────────
    // IMPORTANT: named 'home' so that:
    //   1. Auth middleware redirects here after login
    //   2. RouteServiceProvider::HOME = '/dashboard' still works
    //   3. redirect()->route('home') works everywhere in the app
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

    // ── Inventory ─────────────────────────────────────────────
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/',                        [InventoryController::class, 'index'])->name('index');
        Route::post('/',                       [InventoryController::class, 'store'])->name('store');
        Route::put('/{product}',               [InventoryController::class, 'update'])->name('update');
        Route::delete('/{product}',            [InventoryController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/adjust-stock', [InventoryController::class, 'adjustStock'])->name('adjust');
        // Route::get('/export/csv',           [InventoryController::class, 'exportCsv'])->name('export');
    });

    // ── POS / Sales ───────────────────────────────────────────
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/',                      [PosController::class, 'index'])->name('index');
        Route::post('/checkout',             [PosController::class, 'checkout'])->name('checkout');
        Route::get('/receipt/{transaction}', [PosController::class, 'receipt'])->name('receipt');
    });

    // ── Reports (manager+ only) ───────────────────────────────
    Route::prefix('reports')->name('reports.')->middleware('can_access:reports')->group(function () {
        Route::get('/',           [ReportsController::class, 'index'])->name('index');
        Route::get('/export/csv', [ReportsController::class, 'exportCsv'])->name('export');
    });

    // ── Utang ledger ──────────────────────────────────────────
    Route::prefix('utang')->name('utang.')->group(function () {
        Route::get('/',                 [UtangController::class, 'index'])->name('index');
        Route::post('/',                [UtangController::class, 'store'])->name('store');
        Route::post('/{entry}/payment', [UtangController::class, 'recordPayment'])->name('payment');
        Route::delete('/{entry}',       [UtangController::class, 'destroy'])->name('destroy');
        Route::get('/export/csv',       [UtangController::class, 'exportCsv'])->name('export');
    });

    // ── Users / Team (owner only) ─────────────────────────────
    Route::prefix('users')->name('users.')->middleware('can_access:users')->group(function () {
        Route::get('/',             [UserController::class, 'index'])->name('index');
        Route::post('/invite',      [UserController::class, 'invite'])->name('invite');
        Route::put('/{user}/role',  [UserController::class, 'updateRole'])->name('role');
        Route::delete('/{user}',    [UserController::class, 'destroy'])->name('destroy');
    });

    // ── Settings (owner only) ─────────────────────────────────
    Route::prefix('settings')->name('settings.')->middleware('can_access:settings')->group(function () {
        Route::get('/',        [SettingsController::class, 'index'])->name('index');
        Route::put('/store',   [SettingsController::class, 'updateStore'])->name('store');
        Route::put('/account', [SettingsController::class, 'updateAccount'])->name('account');
    });
});
