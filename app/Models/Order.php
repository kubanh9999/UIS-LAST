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
        'street',
        'status',
        'payment_method',
        'user_id',
        'total_amount',
        'token',
        'order_date',
        'discounts_id',
        'id_product_in_gift', // Thêm cột này
        'province_id',        // Thêm cột này
        'district_id',        // Thêm cột này
        'wards_id',           // Thêm cột này
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
}
