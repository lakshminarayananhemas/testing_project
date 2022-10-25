<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesman_attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'auto_id',
        'salesman_code',
        'start_time',
        'end_time',
        'date',
        'attendance_type',
        'reason',
        'remark',
        'total_login_hours',
        'total_market_hours',
        
    ];
}
