<?php

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

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ReauthenticateController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Settings\EmailUpdateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Settings\PasswordUpdateController;
use App\Http\Controllers\Settings\EmailVerificationController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('guest')->group(function () {
    Route::name('auth.')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('attempt');

        Route::post('register', [RegistrationController::class, 'register'])->name('register');

        Route::prefix('password/reset')->name('password.reset.')->group(function () {
            Route::get('', [ResetController::class, 'create'])->name('create');
            Route::post('', [ResetController::class, 'store'])->name('store');
            Route::get('{user}/{token}', [ResetController::class, 'edit'])->name('edit');
            Route::patch('{user}/{token}', [ResetController::class, 'update'])->name('update');
        });
    });
});
//Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('auth')->group(function () {

    Route::get('mailable', function () {
        return new App\Mail\Settings\EmailChangeVerification(auth()->user());
    });

    Route::get('auth/reauthenticate', [ReauthenticateController::class, 'getReauthenticate'])->name('auth.reauthenticate');
    Route::post('auth/reauthenticate', [ReauthenticateController::class, 'postReauthenticate']);
    Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');

    // email verification
    Route::prefix('verification')->name('verification.')->group(function () {
        Route::post('resend', [EmailVerificationController::class, 'resend'])->name('resend');
        Route::get('verify', [EmailVerificationController::class, 'show'])->name('notice');
        Route::get('verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verify');
    });

    // Settings
    Route::middleware('reauthenticate')->group(function () {
        // email update
        Route::prefix('email')->name('email.')->group(function () {
            Route::post('', [EmailUpdateController::class, 'store'])->name('update');
            Route::delete('', [EmailUpdateController::class, 'destroy'])->name('destroy');
            Route::get('verify/{id}/{hash}', [EmailUpdateController::class, 'verify'])->name('verify');
        });

        // Settings
        Route::get('/settings', [SettingsController::class, '__invoke'])->name('settings');
        Route::patch('/password', [PasswordUpdateController::class, 'update'])->name('password.update');
    });


    // Dashboard
    Route::get('/',  [DashboardController::class, '__invoke'])->name('home');

    // Organizations
    Route::prefix('organizations')->name('organizations.')->group(function () {

        Route::get('/', 'OrganizationsController@index')->name('index')->middleware('remember');

        Route::get('/create', 'OrganizationsController@create')->name('create');
        Route::post('/', 'OrganizationsController@store')->name('store');

        Route::get('/{organization}/edit', 'OrganizationsController@edit')->name('edit');
        Route::put('/{organization}', 'OrganizationsController@update')->name('update');

        Route::delete('/{organization}', 'OrganizationsController@destroy')->name('destroy');
        Route::put('/{organization}/restore', 'OrganizationsController@restore')->name('restore');
    });
});

// 500 error
Route::get('500', function () {
    echo $fail;
});
