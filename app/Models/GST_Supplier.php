<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GST_Supplier extends Model 
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_code',
        'supplier_code',
        'supplier_name',
        'supplier_state',
        'gst_state_code',
        'supplier_gst_in',
        'status', 
    ];
}
