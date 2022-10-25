<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'distributor_code',
        'distributor_branch_code',
        'route_name',
        'route_code',
        'status',
        'van_route_status',
        'population',
        'distance',
        'route_type',
        'city',
        'country_status',
        
    ];
}
