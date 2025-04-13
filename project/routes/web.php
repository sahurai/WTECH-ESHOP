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
