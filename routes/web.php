<?php

Auth::routes();

Route::get('/', function() {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/services', 'HomeController@index')->name('services');
Route::get('/requests', 'HomeController@index')->name('requests');
