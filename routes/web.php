<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtangController;
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */
    // Login
    Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Forgot Password
    Route::get('/forgot-password', [PasswordController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [PasswordController::class, 'showReset'])
        ->name('password.reset');

    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/



Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard')->with('status', 'email-verified');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Inventory Management
    |--------------------------------------------------------------------------
    */

    Route::prefix('inventory')
        ->name('inventory.')
        ->controller(InventoryController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::post('/', 'store')->name('store');

            Route::put('/{product}', 'update')->name('update');

            Route::delete('/{product}', 'destroy')->name('destroy');

            Route::post('/{product}/adjust-stock', 'adjustStock')
                ->name('adjust');

            // Route::get('/export/csv', 'exportCsv')
            //     ->name('export');
        });

    /*
    |--------------------------------------------------------------------------
    | Point of Sale (POS)
    |--------------------------------------------------------------------------
    */

    Route::prefix('pos')
        ->name('pos.')
        ->controller(PosController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::post('/checkout', 'checkout')
                ->name('checkout');

            Route::get('/receipt/{transaction}', 'receipt')
                ->name('receipt');
        });

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::middleware('can_access:reports')
        ->prefix('reports')
        ->name('reports.')
        ->controller(ReportsController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/export/csv', 'exportCsv')
                ->name('export');
        });

    /*
    |--------------------------------------------------------------------------
    | Utang Management
    |--------------------------------------------------------------------------
    */

    Route::prefix('utang')
        ->name('utang.')
        ->controller(UtangController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::post('/', 'store')->name('store');

            Route::post('/{entry}/payment', 'recordPayment')
                ->name('payment');

            Route::delete('/{entry}', 'destroy')
                ->name('destroy');

            Route::get('/export/csv', 'exportCsv')
                ->name('export');
        });

    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */

    Route::middleware('can_access:users')
        ->prefix('users')
        ->name('users.')
        ->controller(UserController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::post('/invite', 'invite')
                ->name('invite');

            Route::put('/{user}/role', 'updateRole')
                ->name('role');

            Route::delete('/{user}', 'destroy')
                ->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::middleware('can_access:settings')
        ->prefix('settings')
        ->name('settings.')
        ->controller(SettingsController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::put('/store', 'updateStore')
                ->name('store');

            Route::put('/account', 'updateAccount')
                ->name('account');
        });

    /*
    |--------------------------------------------------------------------------
    | Password Update
    |--------------------------------------------------------------------------
    */

    Route::post('/password', [PasswordController::class, 'update'])
        ->name('password.change');
});
