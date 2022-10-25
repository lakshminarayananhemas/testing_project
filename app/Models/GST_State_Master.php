<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GST_State_Master extends Model
{
    use HasFactory; 
    protected $fillable = [
        'id',
        'gst_state_Code', 
        'gst_state_name',
        'is_union_territory',
        'is_gst_enabled',
        'status', 
    ];
}
