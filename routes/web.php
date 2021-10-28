<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// cart url is little strange :)
Route::post('/books/{book}/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/books/{book}/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/books/{book}/cart', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/thankyou/{order}', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');

Route::get('/api/cart', function () {
    return session()->get('cart');
});

require __DIR__ . '/auth.php';
