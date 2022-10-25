<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retailer_class extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'retailer_group_code',
        'retailer_class_code',
        'retailer_class_name',
        'turn_over_amount',
    ];
}
