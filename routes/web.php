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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('login');
    Route::post('/login','Auth\AdminLoginController@login')->name('login.submit');
    Route::get('/dashboard','AdminDashboardController@dashboard')->name('dashboard');


    Route::get('/logout','Auth\AdminLoginController@logout')->name('logout');
    Route::post('/logout','Auth\AdminLoginController@logout')->name('logout');
});