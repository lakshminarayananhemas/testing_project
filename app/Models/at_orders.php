<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class at_orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'orderId',
        'customerCode',
        'distributorCode',
        'signature',
        'totalAmount',
        'taxAmount',
        'discount',
    ];
}
