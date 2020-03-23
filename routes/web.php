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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('guest')->group(function () {
    Route::namespace('Auth')->name('auth.')->group(function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login.attempt');
        Route::post('register', 'RegistrationController@register')->name('register');
    });
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('auth')->group(function () {

    Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

    // Organizations
    Route::prefix('verification')->namespace('Auth')->name('verification.')->group(function () {
        Route::post('resend', 'VerificationController@resend')->name('resend');
    });

    // Dashboard
    Route::get('/', 'DashboardController')->name('home');
    Route::patch('/password', 'Auth\PasswordController@update')->name('auth.password.update');

    // Settings
    Route::get('/settings', 'SettingsController@index')->name('settings');

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
