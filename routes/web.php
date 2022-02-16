<?php
// root
Route::get('/{any}', function () {
    return view('index');
})->where('any', '^(?!.*(login|register)).*$');

// auth user
Auth::routes();
