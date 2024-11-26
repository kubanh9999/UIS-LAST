<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'discount_id',
        'price',
        'discount',
        'stock',
        'description',
        'image',
        'sales',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function giftWrappings()
    {
        return $this->hasMany(GiftWrapping::class, 'products_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'products_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
