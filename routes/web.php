<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('home');

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

Route::post('register', [UserController::class, 'authenticate'])->name('registered');

Route::post('login', [UserController::class, 'login'])->name('authorised');

Route::post('rent', [ApartmentController::class, 'create'])->name('create');

Route::get('detail/{id}', [ApartmentController::class, 'detail']);

Route::post('delete/{id}', [ApartmentController::class, 'delete']);