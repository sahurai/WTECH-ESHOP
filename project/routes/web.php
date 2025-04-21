<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;


Route::get('/', [BookController::class,'homepage'])->name('homepage');

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

Route::get('/category/{id}/books', [CategoryController::class, 'booksById'])->name('category.books');

Route::get('/book/{book}',[BookController::class,'show'])->name('books.show');

Auth::routes();

Route::get('/search',[BookController::class,'search'])->name('books.search');

Route::get('/basket',[CartController::class,'index'])->name('basket.index');
