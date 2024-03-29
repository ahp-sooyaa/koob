<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BuyNowController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\RedirectToHomeController;
use App\Http\Controllers\ProfilePasswordController;

Route::get('/', WelcomeController::class)->name('welcome');

/** give conditional redirect path after login successfully */
Route::get('home', RedirectToHomeController::class)->middleware('auth')->name('home');
Route::get('search', SearchController::class)->name('search');

Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/{book:slug}', [BookController::class, 'show'])->name('books.show');

Route::get('carts', [CartController::class, 'index'])->name('cart.index');
Route::post('carts/{book}', [CartController::class, 'store'])->name('cart.store');
Route::patch('carts/{book}', [CartController::class, 'update'])->name('cart.update');
Route::delete('carts/{book}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('buyNow/{book}', [BuyNowController::class, 'store'])->name('buyNow.store');
Route::patch('buyNow/{book}', [BuyNowController::class, 'update'])->name('buyNow.update');
Route::delete('buyNow/{book}', [BuyNowController::class, 'destroy'])->name('buyNow.destroy');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::post('save-for-later/{id}', [SaveForLaterController::class, 'store'])->name('saveForLater.store');
    Route::post('move-to-cart/{id}', [SaveForLaterController::class, 'moveToCart'])->name('moveToCart');

    Route::get('profile/{user:name}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('settings/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/account', [ProfileController::class, 'update'])->name('profile.update');

    Route::patch('profile-password', [ProfilePasswordController::class, 'update'])->name('profile-password.update');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::delete('coupons', [CouponController::class, 'destroy'])->name('coupons.destroy');

    Route::get('addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::patch('addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::post('books/{book}/reviews', [ReviewController::class, 'store'])->name('books.reviews.store');
    Route::patch('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
});

Route::get('books/{book}/reviews', [ReviewController::class, 'index'])->name('books.reviews.index');

Route::get('thank-you/{order}', [CheckoutController::class, 'thankYou'])->name('checkout.thankYou');

Route::get('login-as-admin', function () {
    abort_if(config('app.env') !== 'local', 404);

    Auth::loginUsingId(1);

    return redirect()->route('admin.dashboard');
})->name('loginAsAdmin');

Route::get('login-as-user', function () {
    abort_if(config('app.env') !== 'local', 404);

    Auth::loginUsingId(2);

    return redirect()->route('profile.edit', User::find(2)->name);
})->name('loginAsUser');

Route::get('mailable', function () {
    abort_if(config('app.env') !== 'local', 404);

    $order = App\Models\Order::find(1);

    return new App\Mail\OrderStatusUpdated($order);
});

require __DIR__.'/auth.php';
