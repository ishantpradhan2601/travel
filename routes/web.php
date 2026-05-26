<?php

use App\Http\Controllers\TravelController;
use App\Http\Controllers\BookingController;

Route::get('/', [TravelController::class, 'index'])->name('home');
Route::post('/recommend', [TravelController::class, 'recommend'])->name('recommend');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/confirmation/{reference}', [BookingController::class, 'show'])->name('bookings.confirmation');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\FlightController;
Route::post('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::post('/flights/book', [FlightController::class, 'book'])->name('flights.book');
Route::get('/airports/suggest', [FlightController::class, 'suggest'])->name('airports.suggest');


