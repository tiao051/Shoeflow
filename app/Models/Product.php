<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Các cột cần thiết để hiển thị trên dashboard
    protected $fillable = [
        'name', 
        'price', 
        'image_path', // Đường dẫn hình ảnh, tương đương với 'image' trong mock data
        'color',      // Giả định có cột 'color' để khớp với mock data
        'category_id' 
    ];

    /**
     * Định dạng giá tiền (Ví dụ: 1.890.000 ₫)
     * @param int $price
     * @return string
     */
    public static function formatPrice(int $price): string
    {
        return number_format($price, 0, ',', '.') . ' ₫';
    }

    // Thiết lập quan hệ (ví dụ: với Category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}