<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// --------------------------------------------------------------------------
// Authentication Routes
// --------------------------------------------------------------------------

// Login, Register, Password Reset, etc.
Auth::routes();

// --------------------------------------------------------------------------
// Home & Book Listing
// --------------------------------------------------------------------------

// Home page (shows either homepage content or a listing of books)
Route::get('/', [BookController::class, 'index'])->name('homepage');

// --------------------------------------------------------------------------
// Book Resource Routes
// --------------------------------------------------------------------------

// Display a listing of books
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Show the form for creating a new book
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');

// Store a newly created book in storage
Route::post('/books', [BookController::class, 'store'])->name('books.store');

// Display the specified book
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Show the form for editing the specified book
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');

// Update the specified book in storage
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');

// Remove the specified book from storage
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

// --------------------------------------------------------------------------
// Shopping Cart Routes
// --------------------------------------------------------------------------

// Display the cart contents
Route::get('/basket', [CartController::class, 'index'])->name('basket.index');

// Add a book to the cart
Route::post('/basket', [CartController::class, 'add'])->name('basket.add');

// Update quantities in the cart
Route::post('/basket/update', [CartController::class, 'update'])->name('basket.update');

// Clear the cart completely
Route::post('/basket/clear', [CartController::class, 'clear'])->name('basket.clear');

// --------------------------------------------------------------------------
// Checkout Flow Routes
// --------------------------------------------------------------------------

// Show delivery information form
Route::get('/checkout/delivery', [OrderController::class, 'showDelivery'])->name('checkout.delivery');

// Store delivery information
Route::post('/checkout/delivery', [OrderController::class, 'storeDelivery'])->name('checkout.store');

// Show shipping & payment selection
Route::get('/checkout/shippingpayment', [OrderController::class, 'showShippingPayment'])
    ->name('checkout.shippingpayment');

// Store shipping selection
Route::post('/checkout/shipping', [OrderController::class, 'storeShipping'])
    ->name('checkout.shipping.store');

// Show order summary before confirmation
Route::get('/checkout/summary', [OrderController::class, 'showSummary'])->name('checkout.summary');

// Final order confirmation
Route::post('/checkout/confirm', [OrderController::class, 'confirmOrder'])->name('checkout.confirm');
