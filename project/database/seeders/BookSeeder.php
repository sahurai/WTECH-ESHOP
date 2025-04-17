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
    [
        'title' => 'The Martian',
        'author' => 'Andy Weir',
        'description' => 'A stranded astronaut fights to survive on Mars.',
        'price' => 13.49,
        'quantity' => 25,
        'pages_count' => 369,
        'release_year' => 2011,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'Crown Publishing',
        'isbn' => '9780804139021',
        'edition' => '1st',
        'dimensions' => '21x14x2.5 cm',
        'weight' => 400.00,
    ],
    [
        'title' => '1984',
        'author' => 'George Orwell',
        'description' => 'A dystopian future of surveillance and control.',
        'price' => 10.99,
        'quantity' => 70,
        'pages_count' => 328,
        'release_year' => 1949,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'Secker & Warburg',
        'isbn' => '9780451524935',
        'edition' => '1st',
        'dimensions' => '20x13x2.2 cm',
        'weight' => 350.00,
    ],
    [
        'title' => 'Dune',
        'author' => 'Frank Herbert',
        'description' => 'A science fiction epic of politics, religion, and war.',
        'price' => 15.99,
        'quantity' => 60,
        'pages_count' => 412,
        'release_year' => 1965,
        'language' => 'English',
        'format' => 'Hardcover',
        'publisher' => 'Chilton Books',
        'isbn' => '9780441172719',
        'edition' => '1st',
        'dimensions' => '23x16x3 cm',
        'weight' => 520.00,
    ],
    [
        'title' => 'The Hobbit',
        'author' => 'J.R.R. Tolkien',
        'description' => 'A hobbit sets out on a magical adventure.',
        'price' => 11.50,
        'quantity' => 100,
        'pages_count' => 310,
        'release_year' => 1937,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'Allen & Unwin',
        'isbn' => '9780547928227',
        'edition' => 'Revised',
        'dimensions' => '20x13x2 cm',
        'weight' => 330.00,
    ],
    [
        'title' => 'Brave New World',
        'author' => 'Aldous Huxley',
        'description' => 'A dystopian future driven by technology and conformity.',
        'price' => 9.99,
        'quantity' => 50,
        'pages_count' => 288,
        'release_year' => 1932,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'Chatto & Windus',
        'isbn' => '9780060850524',
        'edition' => 'Classic',
        'dimensions' => '20x13x2 cm',
        'weight' => 310.00,
    ],
    [
        'title' => 'The Name of the Wind',
        'author' => 'Patrick Rothfuss',
        'description' => 'A young man’s rise to power through music, magic, and tragedy.',
        'price' => 16.49,
        'quantity' => 35,
        'pages_count' => 662,
        'release_year' => 2007,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'DAW Books',
        'isbn' => '9780756404741',
        'edition' => '1st',
        'dimensions' => '23x15x4 cm',
        'weight' => 650.00,
    ],
    [
        'title' => 'Fahrenheit 451',
        'author' => 'Ray Bradbury',
        'description' => 'In a world where books are burned, one man questions everything.',
        'price' => 10.49,
        'quantity' => 45,
        'pages_count' => 194,
        'release_year' => 1953,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'Ballantine Books',
        'isbn' => '9781451673319',
        'edition' => 'Modern',
        'dimensions' => '18x11x1.5 cm',
        'weight' => 250.00,
    ],
    [
        'title' => 'To Kill a Mockingbird',
        'author' => 'Harper Lee',
        'description' => 'A gripping tale of race, justice, and moral growth.',
        'price' => 12.00,
        'quantity' => 55,
        'pages_count' => 336,
        'release_year' => 1960,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'J.B. Lippincott & Co.',
        'isbn' => '9780061120084',
        'edition' => '50th Anniversary',
        'dimensions' => '20x13x2.2 cm',
        'weight' => 370.00,
    ],
    [
        'title' => 'The Alchemist',
        'author' => 'Paulo Coelho',
        'description' => 'A philosophical journey of a shepherd searching for his treasure.',
        'price' => 11.90,
        'quantity' => 40,
        'pages_count' => 208,
        'release_year' => 1988,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'HarperOne',
        'isbn' => '9780062315007',
        'edition' => 'International',
        'dimensions' => '20x13x1.5 cm',
        'weight' => 280.00,
    ],
    [
        'title' => 'The Picture of Dorian Gray',
        'author' => 'Oscar Wilde',
        'description' => 'A young man sells his soul for eternal youth and beauty.',
        'price' => 8.50,
        'quantity' => 70,
        'pages_count' => 254,
        'release_year' => 1890,
        'language' => 'English',
        'format' => 'Paperback',
        'publisher' => 'Lippincott’s Monthly Magazine',
        'isbn' => '9780141439570',
        'edition' => 'Oxford Edition',
        'dimensions' => '20x13x2 cm',
        'weight' => 300.00,
    ],
   
        ]);




Book::find(1)?->categories()->attach([1,2,8]);        
Book::find(2)?->categories()->attach([2, 8]);     
Book::find(3)?->categories()->attach([2,3]);     
Book::find(4)?->categories()->attach([2,4]);   
Book::find(5)?->categories()->attach([2,8]); 
Book::find(6)?->categories()->attach([2,5,6]); 
Book::find(7)?->categories()->attach([2,5]); 
Book::find(8)?->categories()->attach([2,1,8]); 
Book::find(9)?->categories()->attach([2,5]);  
Book::find(10)?->categories()->attach([2,1]);       
Book::find(11)?->categories()->attach([2,5]);         
Book::find(12)?->categories()->attach([2,4,6]);         
Book::find(13)?->categories()->attach([2,3,7]);         
Book::find(14)?->categories()->attach([2,4,6]); 
    }
}
