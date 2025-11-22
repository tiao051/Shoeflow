<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Allow these fields to be saved to the DB
    protected $fillable = [
        'user_id',
        'fullname',
        'phone',
        'email',
        'address',
        'note',
        'status',
        'payment_method',
        'subtotal',
        'shipping_fee',
        'tax',
        'coupon_code',
        'discount_amount',
        'total_amount',
    ];

    // Relationship with OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}