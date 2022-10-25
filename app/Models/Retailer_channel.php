<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retailer_channel extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'channel_code',
        'channel_name',
        'sub_channel_code',
        'sub_channel_name',
    ];
}
