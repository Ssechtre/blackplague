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


Route::get('/login', 'CustomerLoginController@showLoginForm')->name('customer.login');
Route::post('/login', 'CustomerLoginController@login')->name('customer.islogin');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'admin'], function(){
    Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');
    Route::resource('codes', 'CodeController');
});


Route::group(['middleware' => 'staff'], function(){

});

Route::group(['middleware' => 'customer'], function(){
    // Route::get('home', 'CustomerController@home')->name('customer.home');
});


Route::get('pos', function(){
    return view('pos');
});

Route::get('createAccount', 'UserController@createAccount');