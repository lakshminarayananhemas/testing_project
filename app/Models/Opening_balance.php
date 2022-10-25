<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opening_balance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'distributor_code',
        'distributor_branch_code',
        'coa_code',
        'credit_amount',
        'debit_amount',
        'opening_balance_date',
        
    ];
}
