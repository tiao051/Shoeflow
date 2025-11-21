<?php

namespace App\Models;

// Thêm các thư viện cần thiết
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Cần thiết cho quan hệ Role

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Đã thêm 'role_id' để khắc phục lỗi vi phạm ràng buộc khóa ngoại.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bio',
        'avatar',
        'role_id', // <-- ĐÃ ĐƯỢC THÊM VÀO ĐÂY
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- MỐI QUAN HỆ ---

    /**
     * Định nghĩa mối quan hệ: Một User thuộc về một Role (N:1).
     */
    public function role(): BelongsTo
    {
        // Liên kết với Role model thông qua cột role_id
        return $this->belongsTo(Role::class);
    }

    /**
     * Định nghĩa mối quan hệ: Một User có nhiều Orders (1:N).
     */
    public function orders(): HasMany
    {
        // Liên kết với Order model thông qua cột user_id
        return $this->hasMany(Order::class);
    }
}