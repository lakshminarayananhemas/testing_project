<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retailer_group extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'channel_code',
        'retailer_group_code',
        'retailer_group_name',
    ];
}
