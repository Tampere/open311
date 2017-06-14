<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'v1'], function() {
    Route::get('services.{extension}', 'ServicesController@index');
});

Route::get('/home', 'HomeController@index')->name('home');
