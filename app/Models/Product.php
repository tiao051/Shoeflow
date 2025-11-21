
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'sale_price', 'category_id', 'brand', 'image', 'stock', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
