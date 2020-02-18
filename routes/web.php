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


// Auth::routes(['register' => 'false']);
Route::get('admin/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login')->name('islogin');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('admin/register', 'Auth\RegisterController@register');

Route::get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'admin'], function(){
	Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');
    Route::resource('codes', 'CodeController');

    Route::get('customer_networks', 'CustomerNetworkController@index')->name('customer_networks.index');
    Route::get('pos', 'HomeController@pos')->name('pos.app');
    Route::get('reports', 'HomeController@reports')->name('reports.app');
});


Route::group(['middleware' => 'staff'], function(){

});

Route::group(['middleware' => 'customer'], function(){
    // Route::get('home', 'CustomerController@home')->name('customer.home');
});

Route::get('createAccount', 'UserController@createAccount');