<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookGenre extends Model
{
    // Specify the table name
    protected $table = 'book_genres';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'book_id',
        'genre_id',
    ];

    // Uncomment if the pivot table does not use timestamps
    // public $timestamps = false;
}
