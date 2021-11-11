<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'admin']
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/books', [BookController::class, 'index'])->name('admin.books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('admin.books.create');
    Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
    // Route::get('/books/{book}', [BookController::class, 'show'])->name('admin.books.show');
});
