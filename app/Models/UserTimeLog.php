<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTimeLog extends Model
{
    use HasFactory;

    protected $table = 'user_time_logs'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'user_id',
        'duration',
        'logged_at',
    ];

    // Định nghĩa quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
