<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [BookController::class, 'index'])->name('homepage');


Route::get('/add', function () {
    // test data

    $isAdmin = true;

    return view('book-page', compact('isAdmin'));
});

Route::get('/edit', function () {
    // test data
    $book = [
        'id' => 1,
        'title' => 'Hunting Adeline',
        'author' => 'H.D. Carlton',
        'image' => 'book-cover-1.png',
        'price' => '18.03',
        'discount' => 18,
        'description' => 'A dark romance thriller with mystery and suspense.',
        'pages' => 300,
        'genre' => 'Mystery',
        'category' => 'Classic',
        'year' => 2020,
        'language' => 'English',
        'format' => 'Hardcover',
        'publisher' => 'XYZ Publishing',
        'isbn' => '978-3-16-148410-0',
        'edition' => '1st',
        'dimensions' => '15x21 cm',
        'weight' => 500
    ];

    $isAdmin = true;

    return view('book-page', compact('book', 'isAdmin'));
});

Route::get('/book/{book}',[BookController::class,'show'])->name('books.show');

Auth::routes();
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/book-page', [BookController::class, 'create'])->name('books.create');

Route::get('/basket',[CartController::class,'index'])->name('basket.index');
Route::post('/basket',[CartController::class,'add'])->name('basket.add');

Route::post('/basket/update', [CartController::class, 'update'])->name('basket.update');
Route::post('/basket/clear', [CartController::class, 'clear'])->name('basket.clear');

Route::get('checkout/delivery',[OrderController::class,'showDelivery'])->name('checkout.delivery');
Route::post('checkout',[OrderController::class,'storeDelivery'])->name('checkout.store');
Route::get('/checkout/shippingpayment', [OrderController::class, 'showShippingPayment'])
    ->name('checkout.shippingpayment');
Route::post('checkout/shipping',[OrderController::class,'storeShipping'])->name('checkout.shipping.store');
Route::get('checkout/summary',[OrderController::class,'showSummary'])->name('checkout.summary');

Route::post('checkout/confirm', [OrderController::class, 'confirmOrder'])->name('checkout.confirm');
