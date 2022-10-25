<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliveryboy extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'distributor_code',
        'distributor_branch_code',
        'deliveryboy_code',
        'deliveryboy_name',
        'phone_no',
        'email_id',
        'daily_allowance',
        'salary',
        'status',
        'default_status',
        
    ];
}
