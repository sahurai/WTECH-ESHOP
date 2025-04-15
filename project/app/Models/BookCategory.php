<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    // Specify the table name
    protected $table = 'book_categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'book_id',
        'category_id',
    ];

    // Uncomment if the pivot table does not use timestamps
    // public $timestamps = false;
}
