<?php

namespace App\Models;

// Thêm các thư viện cần thiết
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany; // Cần thiết để khai báo HasMany

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', // Đã thêm
        'bio',   // Đã thêm
        'avatar',// Đã thêm
    ];

    /**
     * Định nghĩa mối quan hệ: Một User có nhiều Orders.
     */
    public function orders(): HasMany
    {
        // Giả định bảng orders có cột 'user_id' để tham chiếu đến User
        return $this->hasMany(Order::class);
    }

    // Các mối quan hệ hoặc phương thức khác...
}