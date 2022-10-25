<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GST_Distributor extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_code',
        'distributor_code',
        'distributor_name',
        'gstin_number',
        'gst_distr_type',
        'pan_no',
        'gst_state_code',
        'fssai_no',
        'aadhar_no',
        'tcs_applicable',
        'tds_applicable',
        'itr_filed',
        'status', 
    ];
}
