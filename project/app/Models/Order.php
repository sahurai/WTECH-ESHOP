<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Order
 *
 * @property int              $id
 * @property int|null         $user_id
 * @property string|null      $guest_email
 * @property Carbon           $order_date
 * @property float            $total_amount
 * @property string           $status
 * @property string|null      $shipping_name
 * @property string|null      $shipping_address
 * @property string|null      $shipping_city
 * @property string|null      $shipping_state
 * @property string|null      $shipping_postal_code
 * @property string|null      $shipping_country
 * @property string|null      $shipping_method
 * @property string|null      $payment_method
 * @property Carbon|null      $created_at
 * @property Carbon|null      $updated_at
 *
 * @property-read Collection|OrderItem[] $items
 * @property-read User|null $user
 */
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'guest_email',
        'order_date',
        'total_amount',
        'status',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'shipping_method',
        'payment_method'
    ];

    /**
     * Get the items for the order.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user that owns the order.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
