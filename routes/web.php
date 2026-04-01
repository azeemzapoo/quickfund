<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/ideas', function () {
    return view('pages.ideas');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});


