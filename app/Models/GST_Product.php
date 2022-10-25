<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GST_Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_code',
        'product_code',
        'product_name',
        'hsn_code',
        'hsn_name',
        'gst_product_type',
        'status', 
    ];
}
