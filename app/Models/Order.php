<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    // Định nghĩa các trường có thể mass assignment
    protected $fillable = [
        'user_id',
        'total',
        'status',
        // Thêm các trường khác của đơn hàng
    ];

    /**
     * Mối quan hệ: Một Order thuộc về một User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}