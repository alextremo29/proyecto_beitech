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

Route::get('/testOrm','PruebasController@testOrm');
Route::get('api/customer','CustomerController@index');
Route::get('/api/customer/{id}','CustomerController@getProductsByCustomer');
Route::post('/api/order/customer','OrderController@getOrdersByCustomer');
Route::post('/api/order','OrderController@store');
