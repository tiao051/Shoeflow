<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'brand', 'price', 'sale_price', 
        'description', 'color', 'image', 'category_id', 
        'is_new', 'is_active', 'stock',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'integer',
        'sale_price' => 'integer',
        'stock' => 'integer',
    ];

    public static function formatPrice(int $price): string
    {
        return number_format($price, 0, ',', '.') . ' ₫';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}