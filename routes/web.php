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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts', \App\Http\Controllers\PostController::class)->only([
    'index', 'show'
]);

Route::prefix('admin')
    ->middleware(['admin_auth:admin', 'check_active_admin'])
    ->name('admin.')->group(function () {

        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

        Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);

        Route::resource('assets', \App\Http\Controllers\Admin\AssetController::class);
        Route::get('assets/{asset}/download', [\App\Http\Controllers\Admin\AssetController::class, 'download'])->name('assets.download');

        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::patch('categories/{category}/move_down', [\App\Http\Controllers\Admin\CategoryController::class, 'moveDown'])->name('categories.move_down');
        Route::patch('categories/{category}/move_up', [\App\Http\Controllers\Admin\CategoryController::class, 'moveUp'])->name('categories.move_up');

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only([
            'index', 'edit', 'update', 'destroy'
        ]);

        Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Authentication Routes...
    Route::get('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

    // Password Reset Routes...
    Route::get('password/reset', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});
