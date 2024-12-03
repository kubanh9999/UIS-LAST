<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price_gift',
        'stock',
        'image',
        'description',
        'category_id'
    ];

    /**
     * Một ProductType có nhiều Product
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
