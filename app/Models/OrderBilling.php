<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBilling extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_id',
        'distributor_code',
        'salesman_code',
        'route_code',
        'customer_code',
        'invoice_no',
        'cash_dist_amt',
        'cash_dist_percent',
        'scheme_dist_amt',
        'total_invoice_qty',
        'credit_note_adjustment',
        'debit_note_adjustment',
        'gross_amount',
        'total_addition',
        'total_deduction',
        'net_amount',
        'order_date',
        'order_status',
        
    ];
}
