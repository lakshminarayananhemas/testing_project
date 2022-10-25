<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesman_marketvisit_attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'auto_id',
        'sa_id',
        'salesman_code',
        'customer_code',
        'start_time',
        'end_time',
        'current_market_hours',
        'no_sale_reason',
        'date',
        
    ];
}
