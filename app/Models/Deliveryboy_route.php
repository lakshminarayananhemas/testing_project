<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliveryboy_route extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'distributor_code',
        'distributor_branch_code',
        'deliveryboy_code',
        'route_code',
    ];
}
