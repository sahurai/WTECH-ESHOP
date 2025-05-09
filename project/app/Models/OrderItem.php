<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class OrderItem
 *
 * @property int         $id
 * @property int         $order_id
 * @property int         $book_id
 * @property int         $quantity
 * @property float       $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Order $order
 * @property-read Book $book
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'price'
    ];

    /**
     * Get the order that owns the order item.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the book that is associated with the order item.
     *
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
