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

// get number of likes each photo
Route::get('/photos/{photo}/likes', 'Api\PhotosController@getLikes');

// photo detail page
Route::get('/photos/{photo}', 'Api\PhotosController@show');

// like photo
Route::post('/users/{user}/photos/{photo}/like', 'Api\PhotosController@likePhoto');

// unlike photo
Route::delete('/users/{user}/photos/{photo}/unlike', 'Api\PhotosController@unlikePhoto');

// check if current user like this photo
Route::get('/users/{user}/photos/{photo}/check', 'Api\PhotosController@checkLiked');

// add new comment
Route::post('/photos/{photo}/add_comment', 'Api\CommentsController@create');

// get comments each photo
Route::get('/photos/{photo}/comments', 'Api\CommentsController@getComments');
