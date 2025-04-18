<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
Route::get('/', [BookController::class,'homepage'])->name('homepage');


Route::get('/product-demo', function () {
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

    $recommended = [
        $book, // you can repeat the same book for simplicity
        $book,
        $book,
        $book,
        $book,
        $book
    ];

    return view('product-page', [
        'book' => $book,
        'recommendations' => $recommended,
        'isAdmin' => true // or true if you want to test admin mode
    ]);
});


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