<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('login', function () {
    return view('login');
});

Route::get('register', function () {
    return view('registration');
});

Route::get('detail', function() {
    return view('details');
});

Route::get('rent', function() {
    return view('rent');
});

Route::get('edit', function() {
    return view('edit');
});
