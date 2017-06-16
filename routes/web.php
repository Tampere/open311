<?php

Auth::routes();

Route::get('/', function() {
    return view('welcome');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/services', 'Admin\ServicesController');
    Route::resource('/requests', 'Admin\RequestsController');
});
