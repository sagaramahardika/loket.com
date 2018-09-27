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

Route::group( ['prefix' => 'event'], function() {
    Route::get('/get_info/{id}', 'EventAPIController@getInfo');
    
    Route::post('/create', 'EventAPIController@create');
    Route::post('/ticket/create', 'EventAPIController@createTicket');
});

Route::group( ['prefix' => 'transaction'], function() {
    Route::get('/get_info/{id}', 'TransactionController@getInfo');
    
    Route::post('/purchase', 'TransactionController@purchase');
});