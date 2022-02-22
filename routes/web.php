<?php
// root
Route::get('/{any}', function () {
    return view('index');
})->where('any', '^(?!.*(login|register)).*$');

// auth user
Auth::routes();

if (config('app.env') === 'production' or config('app.env') === 'heroku') {
    URL::forceScheme('https');
}
