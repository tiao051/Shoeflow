<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'brand',
        'material',
        'price',
        'discount_price',
        'sizes',
        'stock',
        'main_image',
        'images',
        'color',
        'is_featured',
        'is_active',
        'rating',
        'review_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'sizes' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shoe) {
            if (empty($shoe->slug)) {
                $shoe->slug = Str::slug($shoe->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('is_approved', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function hasDiscount()
    {
        return $this->discount_price !== null && $this->discount_price < $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }
}
