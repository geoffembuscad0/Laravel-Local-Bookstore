<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = ['pending', 'processing', 'out_for_delivery', 'delivered', 'cancelled'];

    public const STATUS_LABELS = [
        'pending' => 'Order received',
        'processing' => 'Preparing your order',
        'out_for_delivery' => 'Out for delivery',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ];

    protected $fillable = [
        'order_number', 'user_id', 'status', 'payment_method', 'payment_status',
        'customer_name', 'customer_email', 'customer_phone', 'shipping_address',
        'shipping_barangay', 'shipping_city', 'shipping_postal_code', 'shipping_country',
        'delivery_landmark', 'subtotal', 'shipping_cost', 'total_amount',
        'customer_notes', 'placed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'placed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }
}
