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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/articles', 'ArticleController@index');
Route::get('/articles/{article}', 'ArticleController@show');

Route::prefix('admin')->namespace('Admin')->middleware('admin_auth:admin')->group(function () {
    Route::resource('articles', 'ArticleController');

    Route::resource('assets', 'AssetController');
    Route::get('assets/{asset}/download', 'AssetController@download')->name('assets.download');

    Route::resource('categories', 'CategoryController');
    Route::patch('categories/{category}/move_down', 'CategoryController@moveDown')->name('categories.move_down');
    Route::patch('categories/{category}/move_up', 'CategoryController@moveUp')->name('categories.move_up');

    Route::get('/home', 'HomeController@index')->name('admin.home');
});

Route::prefix('admin')->namespace('Admin')->group(function () {
    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');
});
