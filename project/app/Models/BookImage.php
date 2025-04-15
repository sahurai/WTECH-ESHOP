<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class BookImage
 *
 * @property int         $id
 * @property int         $book_id
 * @property string      $image_url
 * @property int         $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Book $book
 */
class BookImage extends Model
{
    protected $fillable = [
        'book_id',
        'image_url',
        'sort_order'
    ];

    /**
     * Get the book that owns the image.
     *
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
