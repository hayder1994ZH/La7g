<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([ 'middleware' => 'api', 'prefix' => 'auth/user'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::get('me', 'AuthController@me');
});

Route::group([ 'middleware' => 'api', 'prefix' => 'auth/merchant'], function ($router) {
    Route::post('login', 'MerchantController@login');
    Route::get('me', 'MerchantController@me');
});

Route::apiResource('/user', 'UserController');
Route::apiResource('/merchant', 'MerchantController');
Route::apiResource('/category', 'CategoryController');
Route::apiResource('/SubCategory', 'SubCategoryController');
Route::apiResource('/order', 'OrderController');
Route::put('/order/setStatus/{id}', 'OrderController@setStatus');
Route::get('/my/orders', 'OrderController@myOrders');
Route::post('add/orders', 'OrderController@addOrder');
Route::apiResource('/product', 'ProductController');
Route::put('/product/setStatus/{id}', 'ProductController@setStatus');
Route::apiResource('/image', 'ImageController');
Route::apiResource('/rating', 'RatingController');
Route::apiResource('/slider', 'SliderController');

