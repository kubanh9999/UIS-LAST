<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'discount_percent',
        'description',
        'valid_form',
        'valid_end'
    ];
   
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
