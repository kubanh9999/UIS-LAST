<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'facebook_id',
        'status',
        'remember_token',
        'street',         // Đường
        'wards_id',        // Phường/xã
        'district_id',    // Quận/huyện
        'province_id', 
        'discount_id',
    ];

    /**
     * Relationships
     */

    // Liên kết với Province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    // Liên kết với District
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    // Liên kết với Ward
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'wards_id', 'wards_id');
    }

    // Liên kết với bảng GiftWrapping
    public function giftWrappings()
    {
        return $this->hasMany(GiftWrapping::class, 'user_id');
    }

    // Liên kết với bảng Favorite
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id'); // Sửa khóa ngoại là `user_id` thay vì `products_id`
    }

    // Liên kết với bảng Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Liên kết với bảng Discount thông qua bảng trung gian discounts_product
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discounts_product', 'user_id', 'discount_id');
    }

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
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
