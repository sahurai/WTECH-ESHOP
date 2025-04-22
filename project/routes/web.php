<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;

// --------------------------------------------------------------------------
// Authentication Routes
// --------------------------------------------------------------------------
Auth::routes();

// --------------------------------------------------------------------------
// Home & Book Listing
// --------------------------------------------------------------------------
Route::get('/', [BookController::class, 'index'])->name('homepage');
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// --------------------------------------------------------------------------
// Book Resource Routes
// --------------------------------------------------------------------------
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books',       [BookController::class, 'store'])->name('books.store');

Route::get('/books/{book}',      [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{book}',      [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{book}',   [BookController::class, 'destroy'])->name('books.destroy');

// --------------------------------------------------------------------------
// Shopping Cart Routes
// --------------------------------------------------------------------------
Route::get('/basket',         [CartController::class, 'index'])->name('basket.index');
Route::post('/basket',        [CartController::class, 'add'])->name('basket.add');
Route::post('/basket/update', [CartController::class, 'update'])->name('basket.update');
Route::post('/basket/clear',  [CartController::class, 'clear'])->name('basket.clear');

// --------------------------------------------------------------------------
// Checkout Flow Routes
// --------------------------------------------------------------------------
Route::get('/checkout/delivery',        [CartController::class, 'showDelivery'])->name('checkout.delivery');
Route::post('/checkout/delivery',       [CartController::class, 'storeDelivery'])->name('checkout.store');
Route::get('/checkout/shippingpayment', [CartController::class, 'showShippingPayment'])->name('checkout.shippingpayment');
Route::post('/checkout/shipping',       [CartController::class, 'storeShipping'])->name('checkout.shipping.store');
Route::get('/checkout/summary',         [CartController::class, 'showSummary'])->name('checkout.summary');
Route::post('/checkout/confirm',        [CartController::class, 'confirmOrder'])->name('checkout.confirm');
