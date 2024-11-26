<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipment_date',
        'status',
        'tracking_number',
        'carrier',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
