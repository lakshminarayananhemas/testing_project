<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHierarchyLevelValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_code',
        'level_name',
        'level_value_code',
        'level_value_name',
        'reporting_level_name',
    ];
}
