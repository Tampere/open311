<?php

Auth::routes();

Route::get('/', function() {
    if(auth()->check()) {
        if(auth()->user()->isModerator()) {
            return redirect('home');
        }
        return redirect('client');
    }
    return view('clientwelcome');
});

Route::post('/clientregister', 'ClientController@register');
Route::get('/client/verify/{token}', 'ClientController@verify');
Route::get('/client/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');

Route::middleware(['auth'])->group(function() {
    Route::get('client', 'ClientController@index');
    Route::get('client/manage', 'ClientController@edit');
    Route::post('client/manage', 'ClientController@update');
    Route::post('client/key', 'ClientController@store');
});

Route::middleware(['auth', 'EmployeesOnly'])->group(function() {
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
    Route::delete('/delete-api-user/{id}', 'Admin\RequestsController@destroyApiUser');
    Route::delete('/delete-api-key/{token}', 'Admin\RequestsController@destroyApiKey');
    Route::delete('/images/{photo}', 'Admin\RequestPhotoController@destroy');
    Route::get('/requests/{request}/activity', 'Admin\RequestsController@activities');
});
