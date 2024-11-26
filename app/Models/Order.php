<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'status',
        'payment_method',
        'user_id',
        'total_amount',
        'token',
        'order_date',
        'discounts_id',
       
    ];

    public function shipments()
    {
        return $this->hasOne(Shipment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
