<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'auto_id',
        'company',
        'gst_state_name',
        'supplier_code',
        'supplier_name',
        's_address_1',
        's_address_2',
        's_address_3',
        'country',
        'state',
        'city',
        'postal_code',
        'geo_hierarchy_level',
        'geo_hierarchy_value',
        'phone_no',
        'contact_person',
        's_emailid',
        'tin_no',
        'pin_no', 
        'created_by',
        'modified_by',
    ];
}
