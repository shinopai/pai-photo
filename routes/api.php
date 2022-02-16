<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// get current user
Route::get('/user', function (Request $request) {
    return Auth::user();
});

// get all photos
Route::get('/photos', 'Api\PhotosController@getAll');

// submit new photos
Route::post('/photos', 'Api\PhotosController@create');
