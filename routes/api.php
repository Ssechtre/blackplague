<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('customer_networks')->group(function () {
	Route::post('get_users', 'UserController@getUsers');
	Route::post('connect_users', 'CustomerNetworkController@connectUsers');
	Route::get('get_customer_networks', 'CustomerNetworkController@getCustomersNetworks');
	Route::post('get_user_networks', 'CustomerNetworkController@getUserNetworks');
});

Route::prefix('products')->group(function () {
	Route::post('get_products', 'ProductController@getProducts');
});

Route::prefix('orders')->group(function () {
	Route::post('create_order', 'OrderController@createOrder');
});

Route::prefix('reports')->group(function () {
	Route::post('get_dailysales', 'ReportController@getDailySales');
	Route::post('get_monthlysales', 'ReportController@getMonthlySales');
	Route::post('get_annualsales', 'ReportController@getAnnualSales');
	Route::post('get_customer_commissions', 'ReportController@getCustomerCommissions');
	Route::post('get_payouts', 'ReportController@getPayouts');
});

Route::prefix('commission')->group(function () {
	Route::post('save_commission', 'CommissionController@saveCommission');
});
