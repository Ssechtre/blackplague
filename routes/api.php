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

use App\User;
use App\Code;
use Illuminate\Support\Facades\DB;

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('customer_networks')->group(function () {
	Route::post('get_users', 'UserController@getUsers');
	Route::post('connect_users', 'CustomerNetworkController@connectUsers');

	Route::get('get_customer_networks', 'CustomerNetworkController@getCustomersNetworks');
});

Route::prefix('products')->group(function () {
	Route::post('get_products', 'ProductController@getProducts');
});
