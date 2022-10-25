<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_licence_setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'auto_id',
        'cg_id',
        'ls_tin_no',
        'ls_pin_no',
        'ls_cst_no',
        'ls_drug_license_no1',
        'ls_lic_expiry_date',
        'ls_drug_license_no2',
        'ls_dl1_expiry_date',
        'ls_pest_license_no',
        'ls_dl2_expiry_date',
        'ls_fssai_no',
        'ls_credit_bill',
        'ls_credit_bill_status',
        'ls_credit_limit',
        'ls_credit_limit_status',
        'ls_credit_days',
        'ls_credit_days_status',
        'ls_cash_discount',
        'ls_limit_amount',
        'ls_cd_trigger_action',
        'ls_trigger_amount',
    ];
}
