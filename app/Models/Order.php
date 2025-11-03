<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'shipping_fee',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'notes',
        'paid_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'unpaid' => 'warning',
            'paid' => 'success',
            'refunded' => 'info',
        ];

        return $badges[$this->payment_status] ?? 'secondary';
    }
}
