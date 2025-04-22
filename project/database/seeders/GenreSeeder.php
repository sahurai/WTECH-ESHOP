<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert initial genres
        Genre::insert([
            ['name' => 'Action',    'description' => 'Fast-paced and adrenaline-filled stories'],
            ['name' => 'Thriller',  'description' => 'Tense narratives with suspense and excitement'],
            ['name' => 'Horror',    'description' => 'Scary tales designed to frighten'],
            ['name' => 'Detective', 'description' => 'Mysteries solved by investigators'],
            ['name' => 'Poetry',    'description' => 'Collections of poems and lyrical works'],
            ['name' => 'Biography', 'description' => 'Life stories of real people'],
            ['name' => 'Self-Help', 'description' => 'Guides for personal improvement'],
            ['name' => 'History',   'description' => 'Accounts of past events and eras'],
        ]);
    }
}
