<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_route extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'distributor_code',
        'distributor_branch_code',
        'customer_code',
        'route_code',
        'route_type',
        
    ];
}
