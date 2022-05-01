<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Models\Cart;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

Route::get('/home', HomeController::class)->name('home'); // give conditional redirect path

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

/** cart url is little strange **/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/check', [CartController::class, 'checkStockForCheckout'])->name('cart.check');
Route::post('/books/{book}/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/books/{book}/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/books/{book}/cart', [CartController::class, 'destroy'])->name('cart.destroy');

Route::patch('/cancelCheckoutProcess', [CartController::class, 'cancelCheckoutProcess'])->name('cart.cancelCheckoutProcess');
Route::patch('/timeoutCheckoutProcess', [CartController::class, 'timeoutCheckoutProcess'])->name('cart.timeoutCheckoutProcess');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/coupon', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupon/check', [CouponController::class, 'checkCouponValid'])->name('coupon.check');
    Route::delete('/coupon', [CouponController::class, 'removeCoupon'])->name('coupon.delete');
});

Route::get('/thankyou/{order}', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');

Route::get('/api/cart', function () {
    return auth()->check()
        ? Cart::where('user_id', auth()->id())->get()
        : (session('cart') ? array_values(session('cart')) : []);
});

Route::get('/mailable', function () {
    $order = App\Models\Order::find(1);

    return new App\Mail\OrderStatusUpdated($order);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
