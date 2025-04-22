<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Book
 *
 * @property int            $id
 * @property string         $title
 * @property string         $author
 * @property string|null    $description
 * @property float          $price
 * @property int            $quantity
 * @property int|null       $pages_count
 * @property int|null       $release_year
 * @property string|null    $language
 * @property string|null    $format
 * @property string|null    $publisher
 * @property string|null    $isbn
 * @property string|null    $edition
 * @property string|null    $dimensions
 * @property float|null     $weight
 * @property Carbon|null    $updated_at
 * @property Carbon|null    $created_at
 *
 * @property-read Collection|Category[]     $categories
 * @property-read Collection|Genre[]        $genres
 * @property-read Collection|OrderItem[]    $orderItems
 * @property-read Collection|BookImage[]    $images
 */
class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
    ];

    /**
     * The categories that belong to the book.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_categories', 'book_id', 'category_id');
    }

    /**
     * The genres that belong to the book.
     *
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

    /**
     * Get the order items for the book.
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all images for the book.
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(BookImage::class);
    }
}
