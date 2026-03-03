<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/debug-vercel', function () {
    return [
        'app_url' => config('app.url'),
        'asset_url' => config('app.asset_url'),
        'env' => app()->environment(),
        'is_secure' => request()->secure(),
        'header_x_forwarded_proto' => request()->header('X-Forwarded-Proto'),
    ];
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/rooms', [App\Http\Controllers\HotelController::class, 'publicRooms'])->name('rooms');
Route::get('/rooms/{hotel}', [App\Http\Controllers\HotelController::class, 'publicRoomDetail'])->name('rooms.detail');

// Contact Us & Newsletter
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/subscribe', [ContactController::class, 'subscribe'])->name('subscribe');

// Keep old booking page for generic view, but enhanced flow uses dedicated controller
// Route::match(['get','post'], '/booking', [App\Http\Controllers\HotelController::class, 'bookingPage'])->name('booking');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/history', [HistoryController::class, 'index'])->name('history.view');
    Route::post('/history', [HistoryController::class, 'store'])->name('history.store');

    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.view');
    Route::post('/wishlist', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // New Booking Routes
    Route::get('/checkout', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/checkout', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');

    // Admin routes for managing hotels (optional)
    Route::resource('hotels', \App\Http\Controllers\HotelController::class);

});

require __DIR__ . '/auth.php';
