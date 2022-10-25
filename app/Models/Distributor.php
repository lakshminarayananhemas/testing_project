<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $fillable = [
        'auto_id',
        'distributor_code', 
        'distributor_name',
        'distributor_type',
        'parent_code',
        'supplier',
        'discount_based_on',
        'distributor_permission', 
        'status',
        'country',
        'state',
        'city',
        'postal_code',
        'phone_no',
        'email_id',
        'fssai_no',
        'drug_licence_no',
        'dl_expiry_date',
        'weekly_off',
        'channel_code',
        'category_type',
        'numofsalesmans',
        'salary_budget',
        'latitude',
        'longitude',
        'geo_hierarchy_level',
        'geo_hierarchy_value',
        'sales_hierarchy_level',
        'lob',
        'sales_hierarchy_value',
        'gst_state_name',
        'pan_no',
        'gstin_number',
        'aadhar_no',
        'tcs_applicable',
        'gst_distributor',
        'tds_applicable',
        'password',
        'created_by',
        'modified_by',
    ];
}
