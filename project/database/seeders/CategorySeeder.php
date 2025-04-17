<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Fantasy', 'description' => 'Magical stories'],
            ['name' => 'Sci-Fi', 'description' => 'Futuristic fiction'],
            ['name' => 'Romance', 'description' => 'Love and relationships'],
            ['name' => 'Mystery', 'description' => 'Crime and suspense'],
            ['name' => 'Dystopia', 'description' => 'Dark future and oppressive societies'],
            ['name' => 'Classic', 'description' => 'Timeless literature and novels'],
            ['name' => 'Philosophy', 'description' => 'Books with deep thoughts and meaning'],
            ['name' => 'Adventure', 'description' => 'Exciting journeys and explorations'],
            
            
        ]);
    }
}
