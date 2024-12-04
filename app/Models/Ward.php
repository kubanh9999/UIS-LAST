<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $primaryKey = 'wards_id'; // Đặt primary key là `wards_id`
    public $incrementing = false; // Không sử dụng auto-increment
    protected $fillable = ['wards_id', 'district_id', 'name'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }
}
