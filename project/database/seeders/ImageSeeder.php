<?php

namespace Database\Seeders;
use App\Models\BookImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookImage::insert([
            // Book 1
            ['book_id' => 1, 'image_url' => 'book-cover-1.png', 'sort_order' => 0],
            ['book_id' => 1, 'image_url' => 'book-cover-2.png', 'sort_order' => 1],

            // Book 2
            ['book_id' => 2, 'image_url' => 'book-cover-3.png', 'sort_order' => 0],
            ['book_id' => 2, 'image_url' => 'book-cover-4.png', 'sort_order' => 1],

            // Book 3
            ['book_id' => 3, 'image_url' => 'book-cover-5.png', 'sort_order' => 0],
            ['book_id' => 3, 'image_url' => 'book-cover-6.png', 'sort_order' => 1],

            // Book 4
            ['book_id' => 4, 'image_url' => 'book-cover-1.png', 'sort_order' => 0],
            ['book_id' => 4, 'image_url' => 'book-cover-2.png', 'sort_order' => 1],

            // Book 5
            ['book_id' => 5, 'image_url' => 'book-cover-3.png', 'sort_order' => 0],
            ['book_id' => 5, 'image_url' => 'book-cover-4.png', 'sort_order' => 1],

            // Book 6
            ['book_id' => 6, 'image_url' => 'book-cover-5.png', 'sort_order' => 0],
            ['book_id' => 6, 'image_url' => 'book-cover-6.png', 'sort_order' => 1],

            // Book 7
            ['book_id' => 7, 'image_url' => 'book-cover-1.png', 'sort_order' => 0],
            ['book_id' => 7, 'image_url' => 'book-cover-2.png', 'sort_order' => 1],

            // Book 8
            ['book_id' => 8, 'image_url' => 'book-cover-3.png', 'sort_order' => 0],
            ['book_id' => 8, 'image_url' => 'book-cover-4.png', 'sort_order' => 1],

            // Book 9
            ['book_id' => 9, 'image_url' => 'book-cover-5.png', 'sort_order' => 0],
            ['book_id' => 9, 'image_url' => 'book-cover-6.png', 'sort_order' => 1],

            // Book 10
            ['book_id' => 10, 'image_url' => 'book-cover-1.png', 'sort_order' => 0],
            ['book_id' => 10, 'image_url' => 'book-cover-2.png', 'sort_order' => 1],

            // Book 11
            ['book_id' => 11, 'image_url' => 'book-cover-3.png', 'sort_order' => 0],
            ['book_id' => 11, 'image_url' => 'book-cover-4.png', 'sort_order' => 1],

            // Book 12
            ['book_id' => 12, 'image_url' => 'book-cover-5.png', 'sort_order' => 0],
            ['book_id' => 12, 'image_url' => 'book-cover-6.png', 'sort_order' => 1],

            // Book 13
            ['book_id' => 13, 'image_url' => 'book-cover-1.png', 'sort_order' => 0],
            ['book_id' => 13, 'image_url' => 'book-cover-2.png', 'sort_order' => 1],

            // Book 14
            ['book_id' => 14, 'image_url' => 'book-cover-3.png', 'sort_order' => 0],
            ['book_id' => 14, 'image_url' => 'book-cover-4.png', 'sort_order' => 1],
        ]);
    }
}
