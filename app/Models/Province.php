<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $primaryKey = 'province_id'; // Đặt primary key là `province_id`
    public $incrementing = false; // Không sử dụng auto-increment
    protected $fillable = ['province_id', 'name','id'];

    public function districts()
    {
        return $this->hasMany(District::class, 'province_id', 'province_id');
    }
}
