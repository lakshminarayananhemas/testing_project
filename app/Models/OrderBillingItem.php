<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBillingItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_id',
        'product_code',
        'product_name',
        'batch',
        'exp_date',
        'order',
        'order_qty',
        'inv_qty',
        'mrp',
        'sell_rate',
        'gross_amt',
        'line_disc_amt',
        'tax_amt',
        'net_rate',
        'net_amt',
        
    ];
}
