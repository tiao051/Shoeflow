<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'image_path', 
        'color',  
        'category_id' 
    ];

    /**
     * @param int $price
     * @return string
     */
    public static function formatPrice(int $price): string
    {
        return number_format($price, 0, ',', '.') . ' ₫';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}