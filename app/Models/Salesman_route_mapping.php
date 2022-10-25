<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesman_route_mapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'distributor_code',
        'distributor_branch_code',
        'salesman_code',
        'route_code',
        'status',
    ];
}
