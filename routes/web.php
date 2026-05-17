<?php

use App\Http\Controllers\TravelController;
use App\Http\Controllers\BookingController;

Route::get('/', [TravelController::class, 'index'])->name('home');
Route::post('/recommend', [TravelController::class, 'recommend'])->name('recommend');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/confirmation/{reference}', [BookingController::class, 'show'])->name('bookings.confirmation');

