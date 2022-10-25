<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_general extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'auto_id',
        'cg_distributor_branch',
        'cg_type',
        'cg_customer_code',
        'cg_dist_cust_code',
        'cg_cmpny_cust_code',
        'cg_salesman_code',
        'cg_customer_name',
        'cg_address_1',
        'cg_address_2',
        'cg_address_3',
        'cg_country',
        'cg_state',
        'cg_city',
        'cg_postal_code',
        'cg_phoneno',
        'cg_mobile',
        'cg_latitude',
        'cg_longitude',
        'cg_distance',
        'cg_dob',
        'cg_anniversary',
        'cg_enrollment_date',
        'cg_contact_person',
        'cg_emailid',
        'cg_gst_state',
        'cg_retailer_type',
        'cg_pan_type',
        'cg_panno',
        'cg_aadhaar_no',
        'cg_gstin_number',
        'cg_tcs_applicable',
        'cg_related_party',
        'cg_composite',
        'cg_tds_applicable',
        'ca_customer_status',
        'ca_approval_status',
        // app
        'otp',
        'otpStatus',
        'cg_billType',
        // app end
        'created_by',
        'modified_by',
        
    ];

    public function order_list_unconfirmed()
    {
        return $this->hasMany('App\Models\orders','customer_code','cg_customer_code')
        ->where('status','=', 'Pending');
    }

    public function order_list_confirmed()
    {
        return $this->hasMany('App\Models\orders','customer_code','cg_customer_code')
        ->where('status','=', 'Approved');
    }

    public function order_list_total()
    {
        return $this->hasMany('App\Models\orders','customer_code','cg_customer_code');
    }
}
