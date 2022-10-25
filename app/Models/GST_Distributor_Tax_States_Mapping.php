<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GST_Distributor_Tax_States_Mapping extends Model
{
    use HasFactory; 
    protected $fillable = [
        'id',
        'company_code',
        'distributor_code',
        'to_state_code',
        'status', 
    ];
}
