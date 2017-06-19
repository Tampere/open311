<?php

Auth::routes();

Route::get('/', function() {
    return view('welcome');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@show')->name('profile');
    Route::resource('/services', 'Admin\ServicesController');
    Route::get('/requests/archived', 'Admin\RequestsController@archived')->name('requests.archived');
    Route::resource('/requests', 'Admin\RequestsController');
});
