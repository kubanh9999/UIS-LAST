<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total_price',
        'product_in_gift_id',
        'gift_id',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function productInGift()
    {
        return $this->belongsTo(ProductInGift::class);
    }

    public function gift()
    {
        return $this->belongsTo(ProductType::class, 'gift_id');
    }

}
