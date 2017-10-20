<?php

Auth::routes();

Route::get('/', function() {
    if(auth()->check()) {
        return redirect('home');
    }
    return view('welcome');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@profile')->name('profile');
    Route::get('/users', 'HomeController@userslist')->name('users');
    Route::put('/users/{user}', 'HomeController@update');
    Route::delete('/users/{user}', 'HomeController@destroy');
    Route::post('/users/{user}/admin', 'HomeController@setAdmin');
    Route::delete('/users/{user}/admin', 'HomeController@setNotAdmin');
    Route::resource('/services', 'Admin\ServicesController');
    Route::get('/requests/archived', 'Admin\RequestsController@archived')->name('requests.archived');
    Route::resource('/requests', 'Admin\RequestsController');
    Route::post('/delete-requests', 'Admin\RequestsController@destroyRequests');
    Route::delete('/images/{photo}', 'Admin\RequestPhotoController@destroy');
    Route::get('/requests/{request}/activity', 'Admin\RequestsController@activities');
});
