<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserController::class, 'authenticate'])->name('registered');
Route::post('login', [UserController::class, 'login'])->name('authorised');
Route::post('logout', [UserController::class, 'logout'])->name('user.logout');

Route::get('/', [ApartmentController::class, 'mostRented'])->name('home');
Route::get('search', [HomePageController::class, 'search'])->name('apartment.search');

Route::post('rent', [ApartmentController::class, 'create'])->name('apartment.create');

Route::get('detail/{apartment}', [ApartmentController::class, 'detail'])->name('apartment.detail');
Route::get('detail/billing/{apartment}', [BookingController::class, 'checkout'])->name('booking.checkout');
Route::post('detail/billing/{apartment}/payed', [BookingController::class, 'booking'])->name('confirmed');
Route::get('edit/{apartment}', [ApartmentController::class, 'edit_index'])->middleware('auth')->name('apartment.edit');
Route::post('edit/{apartment}', [ApartmentController::class, 'edit'])->name('apartment.update');
Route::post('delete/{apartment}', [ApartmentController::class, 'delete'])->name('apartment.delete');

Route::get('userprofile/{user}', [UserController::class, 'userprofile'])->name('userprofile.user');
Route::get('userprofile/{user}/edit', [UserController::class, 'edit_user_profile_index'])->middleware('auth')->name('user.edit_profile');
Route::post('userprofile/{user}/edit', [UserController::class, 'edited'])->name('user.edited_profile');
Route::post('userprofile/{user}/delete', [UserController::class, 'deleteProfile'])->name('user.delete_profile');

Route::get('/adminpanel', [AdminController::class, 'index'])->name('adminpanel');
Route::post('/adminpanel/{user}', [AdminController::class, 'changeStatus'])->name('adminpanel.changeStatus');
