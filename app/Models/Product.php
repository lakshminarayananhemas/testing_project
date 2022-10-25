<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'auto_id',
        'phll',
        'product_code',
        'product_name',
        'short_name',
        'uom',
        'conversion_factor',
        'ean_code',
        'net_wgt',
        'weight_type',
        'shelf_life',
        'product_type',
        'drug_product',
        'status',
        'serial_no_exist',
        'second_serial_no_applicable',
        'second_serial_no_mandatory',
        'ghl',
        'hsn_code',
        'hsn_name',
        'gst_p_type',
        'brandcategory',
        'brandpack',
        'division',

        'mrp',
        'ptr',
        'available_quantity',
        'sku_type',
        'sih',
        'soq',
        'mss',

        'created_by',
        'modified_by',
    ];
}
