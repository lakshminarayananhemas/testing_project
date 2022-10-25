<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_coverage_attributes extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'auto_id',
        'cg_id',
        'ca_coverage_mode',
        'ca_coverage_frequency',
        'ca_sales_route',
        'ca_delivery_route',
        'ca_channel',
        'ca_subchannel',
        'ca_group',
        'ca_class',
        'ca_parent_child',
        'ca_attach_parent',
        'ca_key_account',
        'ca_ra_mapping',
    ];
}
