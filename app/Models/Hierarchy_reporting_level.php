<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hierarchy_reporting_level extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'auto_id',
        'company_id',
        'hierarchy_level_id',
        'reporting_level_name',
        
    ];
}
