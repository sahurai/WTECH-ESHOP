<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // test data
    $books = [
        [
            'title' => 'Book One',
            'author' => 'Author A',
            'price' => '10.00',
            'discount' => 15,
            'image' => 'book-cover-1.png',
        ],
        [
            'title' => 'Book Two',
            'author' => 'Author B',
            'price' => '15.00',
            'discount' => null,
            'image' => 'book-cover-2.png',
        ],
    ];

    $isAdmin = false;

    return view('category', compact('books', 'isAdmin'));
});


Route::get('/product-demo', function () {
    $book = [
        'id' => 1,
        'title' => 'Hunting Adeline',
        'author' => 'H.D. Carlton',
        'image' => 'book-cover-1.png',
        'price' => '18,03',
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