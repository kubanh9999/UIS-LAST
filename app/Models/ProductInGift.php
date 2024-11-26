<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInGift extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_in_gift';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'gift_id',     // Thêm gift_id vào đây
        'user_id',     // Thêm user_id vào đây
        'quantity',
        'price',
        'total_price', // Thêm total_price vào đây
    ];

    /**
     * Một ProductInGift thuộc về một Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Một ProductInGift thuộc về một GiftWrapping
     */
    public function giftWrapping()
    {
        return $this->belongsTo(GiftWrapping::class, 'gift_id');
    }
    public function gift()
    {
        return $this->belongsTo(ProductType::class, 'gift_id');
    }
    /**
     * Một ProductInGift thuộc về một User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
