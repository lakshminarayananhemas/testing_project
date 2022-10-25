<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesman extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'salesmen';


    // protected $fillable = [
    //     'id',
    //     'distributor_code',
    //     'distributor_branch_code',
    //     'salesman_name',
    //     'email_id',
    //     'phone_no',
    //     'daily_allowance',
    //     'salary',
    //     'status',
    //     'salesman_code',
    //     'dob',
    //     'doj',
    //     'password',
    //     'salesman_type',
    //     'sm_unique_code',
    //     'third_party_empcode',
    //     'replacement_for',

    //     'attach_company',
    //     'sales_type',
    //     'godown_status',
    //     'aadhaar_no',
    //     'sfa_status',
    //     'device_no',
    //     'sfa_pass_status',
    //     'salesman_image',

    //     '',
    // ];
}
