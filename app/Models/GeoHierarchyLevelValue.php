<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoHierarchyLevelValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_code',
        'level_name',
        'level_code',
        'company_value',
        'reporting_to',
    ];
}
