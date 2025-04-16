<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
    [
        'title' => 'The Lost World',
        'author' => 'Arthur Conan Doyle',
        'description' => 'A thrilling adventure in a hidden land of dinosaurs.',
        'price' => 12.99,
        'quantity' => 50,
        'pages_count' => 320,
        'release_year' => 1912,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'Penguin Classics',
        'isbn' => '9780140437650',
        'edition' => '1st',
        'dimensions' => '20x13x3 cm',
        'weight' => 350.00
    ],
    [
        'title' => 'Interstellar Mission',
        'author' => 'Carl Sagan',
        'description' => 'A deep dive into the mysteries of the universe and space travel.',
        'price' => 19.99,
        'quantity' => 30,
        'pages_count' => 400,
        'release_year' => 1990,
        'language' => 'English',
        'format' => 'Hardcover',
        'publisher' => 'Cosmos Publishing',
        'isbn' => '9780671027032',
        'edition' => '2nd',
        'dimensions' => '24x16x4 cm',
        'weight' => 550.00
    ],
    [
        'title' => 'Heartbeats',
        'author' => 'Nicholas Sparks',
        'description' => 'An emotional journey through love and heartbreak.',
        'price' => 9.99,
        'quantity' => 80,
        'pages_count' => 280,
        'release_year' => 2005,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'Romance House',
        'isbn' => '9780446696166',
        'edition' => '1st',
        'dimensions' => '21x14x2 cm',
        'weight' => 300.00
    ],
    [
        'title' => 'Sherlock\'s Return',
        'author' => 'Arthur Conan Doyle',
        'description' => 'The return of the world’s most famous detective.',
        'price' => 14.99,
        'quantity' => 40,
        'pages_count' => 350,
        'release_year' => 1905,
        'language' => 'English',
        'format' => 'Hardcover',
        'publisher' => 'Baker Street Press',
        'isbn' => '9780199536955',
        'edition' => 'Deluxe',
        'dimensions' => '23x15x3.5 cm',
        'weight' => 500.00
    ],
        ]);




Book::find(1)?->categories()->attach([1,2,3,4]);        
Book::find(2)?->categories()->attach([2, 3]);     
Book::find(3)?->categories()->attach([1, 4]);     
Book::find(4)?->categories()->attach([4]);        

    }
}
