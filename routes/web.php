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


Auth::routes();

Route::get('/', function(){
    return redirect('login');
});

Route::get('', function(){
    return redirect('login');
});

Route::group(['middleware' => 'admin'], function(){

	Route::get('home', 'HomeController@index')->name('home');
    Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');
    Route::resource('codes', 'CodeController');

    Route::get('customer_networks', 'CustomerNetworkController@index')->name('customer_networks.index');
    Route::get('point_of_sales', 'HomeController@pos')->name('point_of_sales.app');
    Route::get('reports', 'HomeController@reports')->name('reports.app');
    Route::get('payouts', 'HomeController@payouts')->name('payouts');
});

Route::group(['middleware' => 'customer'], function(){
    Route::get('privileges', 'HomeController@privileges')->name('customer.home');
    Route::get('my_networks', 'HomeController@networks')->name('user.networks');
    Route::get('pos', 'HomeController@pos')->name('pos.app');
    Route::get('commissions', 'HomeController@commissions')->name('user.commissions');
    Route::get('change_password', 'HomeController@change_password')->name('user.profile');
    Route::put('change_password/{user}', 'UserController@changePassword')->name('user.change_password');
});

Route::group(['middleware' => 'staff'], function(){
    Route::get('staff_pos', 'HomeController@pos')->name('point_of_sales.staff');
    Route::get('staff_customer_networks', 'CustomerNetworkController@index')->name('customer_networks.staff');
});

Route::get('createAccount', 'UserController@createAccount');

