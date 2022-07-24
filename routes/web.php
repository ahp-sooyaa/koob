<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BuyNowController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

/** give conditional redirect path after login successfully */
Route::get('home', HomeController::class)->name('home');
Route::get('search', SearchController::class)->name('search');

Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/{book:slug}', [BookController::class, 'show'])->name('books.show');

Route::get('carts', [CartController::class, 'index'])->name('cart.index');
Route::post('carts/{book}', [CartController::class, 'store'])->name('cart.store');
Route::patch('carts/{book}', [CartController::class, 'update'])->name('cart.update');
Route::delete('carts/{book}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('carts/checkStockForCheckout', [CartController::class, 'checkStockForCheckout'])->name('cart.checkStockForCheckout');

Route::post('buyNow/{book}', [BuyNowController::class, 'store'])->name('buyNow.store');
Route::patch('buyNow/{book}', [BuyNowController::class, 'update'])->name('buyNow.update');
Route::delete('buyNow/{book}', [BuyNowController::class, 'destroy'])->name('buyNow.destroy');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::post('save-for-later/{id}', [SaveForLaterController::class, 'store'])->name('saveForLater.store');
    Route::post('move-to-cart/{id}', [SaveForLaterController::class, 'moveToCart'])->name('moveToCart');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile-password/update', [ProfileController::class, 'profilePasswordUpdate'])->name('profile-password.update');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::delete('coupons', [CouponController::class, 'destroy'])->name('coupons.destroy');
});

Route::get('thankyou/{order}', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');

Route::get('mailable', function () {
    $order = App\Models\Order::find(1);

    return new App\Mail\OrderStatusUpdated($order);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
