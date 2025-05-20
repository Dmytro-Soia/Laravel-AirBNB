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

Route::get('/', [ApartmentController::class, 'mostRented'])->name('home');

Route::get('search', [HomePageController::class, 'search']);

Route::post('register', [UserController::class, 'authenticate'])->name('registered');

Route::post('login', [UserController::class, 'login'])->name('authorised');

Route::post('rent', [ApartmentController::class, 'create'])->name('create');

Route::get('detail/{apartment}', [ApartmentController::class, 'detail']);

Route::post('delete/{apartment}', [ApartmentController::class, 'delete']);

Route::get('edit/{apartment}', [ApartmentController::class, 'edit_index']);

Route::post('edit/{apartment}', [ApartmentController::class, 'edit']);

Route::get('detail/billing/{apartment}', [BookingController::class, 'checkout']);

Route::post('detail/billing/{apartment}/payed', [BookingController::class, 'booking'])->name('confirmed');

Route::post('logout', [UserController::class, 'logout']);

