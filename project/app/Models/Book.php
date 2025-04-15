<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'author',
        'description',
        'price',
        'quantity',
        'pages_count',
        'release_year',
        'language',
        'format',
        'publisher',
        'isbn',
        'edition',
        'dimensions',
        'weight',
        'cover_url',
    ];

    /**
     * The categories that belong to the book.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_categories', 'book_id', 'category_id');
    }

    /**
     * The genres that belong to the book.
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

    /**
     * Get the order items for the book.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
