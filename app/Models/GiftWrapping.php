<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftWrapping extends Model
{
    use HasFactory;

    // Tên bảng tương ứng
    protected $table = 'gift_wrappings';

    // Các cột có thể được gán giá trị một cách tự động
    protected $fillable = [
        'products_id',
        'user_id',
        'price',
        'tag',
    ];

    
    // Quan hệ với bảng Product (Gift Wrapping thuộc về một Product)
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    // Quan hệ với bảng User (Gift Wrapping thuộc về một User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
