<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesman_jc_route_mapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'distributor_code',
        'customer_code',
        'salesman_code',
        'route_code',
        'jc_month',
        'frequency',
        'daily',
        'weekly',
        'monthly',
        'status',
        
    ];
}
