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

// Login Routes
Route::get('/login', [ 
    'uses'  => 'LoginController@index',
    'as'    => 'login-form',
]);

Route::post('/login', [ 
    'uses'  => 'LoginController@login',
    'as'    => 'login',
]);

// Register Routes
Route::get('/register', [ 
    'uses'  => 'RegisterController@index',
    'as'    => 'register-form',
]);

Route::post('/register', [ 
    'uses'  => 'RegisterController@register',
    'as'    => 'register',
]);

Route::get('/logout', [
    'uses'  => 'LoginController@logout',
    'as'    => 'logout',
]);

Route::group( ['prefix' => 'member'], function() {
    
    Route::get('/', [ 
        'uses'  => 'UserController@index',
        'as'    => 'user.dashboard',
    ]);

    Route::group( ['prefix' => 'event'], function() {
        Route::get('/', [ 
            'uses'  => 'EventController@index',
            'as'    => 'event.index',
        ]);
        Route::get('/create', [ 
            'uses'  => 'EventController@create',
            'as'    => 'event.create',
        ]);
        Route::get('/edit/{id}', [ 
            'uses'  => 'EventController@edit',
            'as'    => 'event.edit',
        ]);

        Route::post('/', [
            'uses'  => 'EventController@all',
            'as'    => 'event.all',
        ]);
        Route::post('/store', [
            'uses'  => 'EventController@store',
            'as'    => 'event.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'EventController@update',
            'as'    => 'event.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'EventController@delete',
            'as'    => 'event.delete',
        ]);
    });

    Route::group( ['prefix' => 'ticket'], function() {       
        Route::get('/', [ 
            'uses'  => 'TicketController@index',
            'as'    => 'event.index',
        ]);
        Route::get('/create', [ 
            'uses'  => 'TicketController@create',
            'as'    => 'event.create',
        ]);
        Route::get('/edit/{id}', [ 
            'uses'  => 'TicketController@edit',
            'as'    => 'event.edit',
        ]);

        Route::post('/', [
            'uses'  => 'TicketController@all',
            'as'    => 'event.all',
        ]);
        Route::post('/store', [
            'uses'  => 'TicketController@store',
            'as'    => 'event.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'TicketController@update',
            'as'    => 'event.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'TicketController@delete',
            'as'    => 'event.delete',
        ]);
    });

});