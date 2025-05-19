<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



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

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('search', [HomePageController::class, 'search']);

Route::post('register', [UserController::class, 'authenticate'])->name('registered');

Route::post('login', [UserController::class, 'login'])->name('authorised');

Route::post('rent', [ApartmentController::class, 'create'])->name('create');

Route::get('detail/{id}', [ApartmentController::class, 'detail']);

Route::post('delete/{id}', [ApartmentController::class, 'delete']);

Route::get('edit/{id}', [ApartmentController::class, 'edit_index']);

Route::post('edit/{id}', [ApartmentController::class, 'edit']);

Route::get('detail/billing/{id}', [BookingController::class, 'checkout']);

Route::post('detail/billing/{id}/payed', [BookingController::class, 'booking'])->name('confirmed');

Route::post('logout', [UserController::class, 'logout']);

