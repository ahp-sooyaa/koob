<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    // Route::get('unread-notifications', [NotificationController::class, 'unreadNotifications'])->name('unread-notifications');
    Route::get('notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');

    Route::get('books', [BookController::class, 'index'])->name('books.index');
    Route::get('books/create', [BookController::class, 'create'])->name('books.create');
    Route::get('books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::post('books', [BookController::class, 'store'])->name('books.store');
    Route::patch('books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    // Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('orders/{order}', [OrderController::class, 'update'])->name('orders.update');

    Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('coupons/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::get('coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::patch('coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
});
