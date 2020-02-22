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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('trips/storeListValidate', 'TripController@storeListValidate');

Route::apiResource('trips', 'TripController');

//Definimos las rutas del recurso
Route::apiResource('customers', 'CustomerController');

//definimos rutas de filtros, es recomendable hacerlo con un post
Route::get('customers/{key1}/{value1}', 'CustomerController@index');
Route::get('customers/{key1}/{value1}/{key2}/{value2}', 'CustomerController@index');
Route::get('customers/{key1}/{value1}/{key2}/{value2}/{key3}/{value3}', 'CustomerController@index');
