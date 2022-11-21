<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BuyNowController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProfilePasswordController;
use App\Http\Controllers\RedirectToHomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\SearchController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//dd(User::find(2)->addresses);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

/** give conditional redirect path after login successfully */
Route::get('home', RedirectToHomeController::class)->name('home');
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
    Route::post('addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::patch('addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
});

Route::get('thank-you/{order}', [CheckoutController::class, 'thankYou'])->name('checkout.thankYou');


Route::get('login-as-admin', function (){
    abort_if(config('app.env') !== 'local',405);

    Auth::loginUsingId(1);

    return redirect()->route('admin.dashboard');
})->name('loginAsAdmin');

Route::get('login-as-user', function (){
    abort_if(config('app.env') !== 'local',405);

    Auth::loginUsingId(2);

    return redirect()->route('profile.show', User::find(2)->name);
})->name('loginAsUser');

Route::get('mailable', function () {
    $order = App\Models\Order::find(1);

    return new App\Mail\OrderStatusUpdated($order);
});

require __DIR__ . '/auth.php';
