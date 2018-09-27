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

Route::get('/', [ 
    'uses'  => 'HomeController@index',
    'as'    => 'home',
]);

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
        Route::get('/{id}/ticket', [ 
            'uses'  => 'TicketController@index',
            'as'    => 'ticket.index',
        ]);
        Route::get('/{id}/ticket/create', [ 
            'uses'  => 'TicketController@create',
            'as'    => 'ticket.create',
        ]);
        Route::get('/{eventId}/ticket/edit/{ticketId}', [ 
            'uses'  => 'TicketController@edit',
            'as'    => 'ticket.edit',
        ]);

        Route::post('/', [
            'uses'  => 'EventController@all',
            'as'    => 'event.all',
        ]);
        Route::post('/ticket', [
            'uses'  => 'TicketController@all',
            'as'    => 'ticket.all',
        ]);
        Route::post('/store', [
            'uses'  => 'EventController@store',
            'as'    => 'event.store',
        ]);
        Route::post('/ticket/store', [
            'uses'  => 'TicketController@store',
            'as'    => 'ticket.store',
        ]);

        Route::patch('/update/{id}', [
            'uses'  => 'EventController@update',
            'as'    => 'event.update',
        ]);
        Route::patch('/ticket/update/{id}', [
            'uses'  => 'TicketController@update',
            'as'    => 'ticket.update',
        ]);

        Route::delete('/delete/{id}', [
            'uses'  => 'EventController@delete',
            'as'    => 'event.delete',
        ]);
        Route::post('/ticket/delete/{id}', [
            'uses'  => 'TicketController@delete',
            'as'    => 'ticket.delete',
        ]);
    });

});

Route::group( ['prefix' => 'event'], function() {
    Route::get('/{id}/buy', [ 
        'uses'  => 'EventGuestController@buy',
        'as'    => 'event.buy',
    ]);

    Route::post('/process', [ 
        'uses'  => 'EventGuestController@process',
        'as'    => 'event.process',
    ]);
});