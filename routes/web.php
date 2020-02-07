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
    Route::prefix('user')->group(function(){
        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('create', 'UserController@create')->name('user.create');
        Route::post('/', 'UserController@store')->name('user.store');
        Route::get('/{id}', 'UserController@show')->name('user.show');
        Route::get('{user}/edit', 'UserController@edit')->name('user.edit');
        Route::patch('/{user}', 'UserController@update')->name('user.update');
    });

    
    Route::prefix('customer')->group(function(){
        Route::get('/', 'CustomerController@index')->name('customer.index');
        Route::get('create', 'CustomerController@create')->name('customer.create');
        Route::post('/', 'CustomerController@store')->name('customer.store');
        Route::get('/{id}', 'CustomerController@show')->name('customer.show');
        Route::get('/{id}/edit', 'CustomerController@edit')->name('customer.edit');
        Route::put('/{id}', 'CustomerController@update')->name('customer.update');
    });
});


// Route::get('product', 'ProductController@index')->name('product.index')->middleware('staff');
// Route::get('admin', 'HomeController@admin')->middleware('admin');

    // Route::prefix('user')->group(function(){
    //     Route::get('/', 'UserController@index')->name('user.index');
    //     Route::get('create', 'UserController@create')->name('user.create');
    //     Route::post('/', 'UserController@store')->name('user.store');
    //     Route::get('/{id}', 'UserController@show')->name('user.show');
    // });
Route::get('product', 'ProductController@index')->name('product.index');

Route::group(['middleware' => 'staff'], function(){
    // Route::prefix('product')->group(function(){
        Route::get('product/create', 'ProductController@create')->name('product.create');
        Route::post('product/', 'ProductController@store')->name('product.store');
        Route::get('product/{id}', 'ProductController@show')->name('product.show');
        Route::get('product/{id}/edit', 'ProductController@edit')->name('product.edit');
        Route::patch('product/{id}', 'ProductController@update')->name('product.update');
    // });
});

Route::group(['middleware' => 'customer'], function(){
    // Route::get('home', 'CustomerController@home')->name('customer.home');
});

Route::prefix('code')->group(function(){
    Route::get('/', 'CodeController@index')->name('code.index');
    Route::get('/create', 'CodeController@create')->name('code.create');
    Route::post('/', 'CodeController@store')->name('code.store');
    Route::get('/{id}', 'CodeController@show')->name('code.show');
    Route::get('/{id}/edit', 'CodeController@edit')->name('code.edit');
    Route::patch('/{id}', 'CodeController@update')->name('code.update');
});



// VUE

Route::prefix('vue')->group(function(){
    Route::get('/', 'UserController@vue')->name('vue.index');
});


Route::get('pos', function(){
    return view('pos');
});