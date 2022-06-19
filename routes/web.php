<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BuyNowController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

/** give conditional redirect path after login successfully */
Route::get('/home', HomeController::class)->name('home');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::get('/carts', [CartController::class, 'index'])->name('cart.index');
Route::post('/carts/{book}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/carts/{book}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carts/{book}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/carts/checkStockForCheckout', [CartController::class, 'checkStockForCheckout'])->name('cart.checkStockForCheckout');

Route::patch('/cancelCheckoutProcess', [CartController::class, 'cancelCheckoutProcess'])->name('cart.cancelCheckoutProcess');
Route::patch('/timeoutCheckoutProcess', [CartController::class, 'timeoutCheckoutProcess'])->name('cart.timeoutCheckoutProcess');
Route::post('/{id}/saveforlater', [CartController::class, 'saveforlater'])->name('saveforlater');
Route::post('/{id}/movetocart', [CartController::class, 'movetocart'])->name('movetocart');

Route::post('/buyNow/{book}', [BuyNowController::class, 'store'])->name('buyNow.store');
Route::patch('/buyNow/{book}', [BuyNowController::class, 'update'])->name('buyNow.update');
Route::delete('/buyNow/{book}', [BuyNowController::class, 'destroy'])->name('buyNow.destroy');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/coupon', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupon/check', [CouponController::class, 'checkCouponValid'])->name('coupon.check');
    Route::delete('/coupon', [CouponController::class, 'removeCoupon'])->name('coupon.destroy');
});

Route::get('/thankyou/{order}', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');

Route::get('/api/cart', function () {
    return session('cart') ? array_values(session('cart')) : [];
    // session('buyNow');
});

Route::get('saveforlater', function () {
    return session('saveforlater');
});

Route::get('/mailable', function () {
    $order = App\Models\Order::find(1);

    return new App\Mail\OrderStatusUpdated($order);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
