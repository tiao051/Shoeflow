<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($now < $this->start_date || $now > $this->end_date) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $orderTotal): float
    {
        if ($orderTotal < $this->min_purchase) {
            return 0;
        }

        $discount = $this->type === 'percentage' 
            ? ($orderTotal * $this->value / 100)
            : $this->value;

        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }

        return round($discount, 2);
    }
}
