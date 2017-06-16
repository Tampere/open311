<?php

Route::get('services.{extension}', 'ServicesController@index');
Route::get('services/{service_code}.{extension}', 'ServicesController@show');

Route::get('requests.{extension}', 'RequestsController@index');
Route::post('requests.{extension}', 'RequestsController@store');
Route::get('requests/{service_request_id}.{extension}', 'RequestsController@show');