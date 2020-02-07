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


Route::get('products', function(){
    return 'CHECK';
});
