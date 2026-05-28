<?php

use App\Http\Controllers\TravelController;
use App\Http\Controllers\BookingController;

Route::get('/', [TravelController::class, 'index'])->name('home');
Route::post('/recommend', [TravelController::class, 'recommend'])->name('recommend')->middleware('auth');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index')->middleware('auth');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store')->middleware('auth');
Route::get('/bookings/confirmation/{reference}', [BookingController::class, 'show'])->name('bookings.confirmation')->middleware('auth');
Route::post('/bookings/cancel/{reference}', [BookingController::class, 'cancel'])->name('bookings.cancel')->middleware('auth');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\FlightController;
Route::post('/flights/search', [FlightController::class, 'search'])->name('flights.search')->middleware('auth');
Route::post('/flights/book', [FlightController::class, 'book'])->name('flights.book')->middleware('auth');
Route::get('/airports/suggest', [FlightController::class, 'suggest'])->name('airports.suggest');

use App\Http\Controllers\HotelController;
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index')->middleware('auth');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
Route::post('/hotels/{hotel}/book', [HotelController::class, 'book'])->name('hotels.book')->middleware('auth');

Route::get('/api/hotels', [HotelController::class, 'apiSearch'])->name('api.hotels.search');
Route::get('/api/hotels/{hotel}', [HotelController::class, 'apiDetail'])->name('api.hotels.detail');

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

Route::get('/test', function () {
    $users = User::all();
    return view('test', compact('users'));
})->name('test');

Route::post('/test/login-as/{user}', function (User $user) {
    Auth::login($user);
    request()->session()->regenerate();
    return redirect()->route('home')->with('success', "Logged in instantly as {$user->name}!");
})->name('test.login-as');

Route::post('/test/check-credentials', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    $user = User::where('email', $credentials['email'])->first();
    if ($user && Hash::check($credentials['password'], $user->password)) {
        return response()->json([
            'success' => true,
            'message' => "Valid credentials! Access granted for {$user->name}."
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => "Invalid password for this account."
    ]);
})->name('test.check-credentials');

use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/companions', [ProfileController::class, 'storeCompanion'])->name('profile.companions.store');
    Route::delete('/profile/companions/{companion}', [ProfileController::class, 'destroyCompanion'])->name('profile.companions.destroy');
});





