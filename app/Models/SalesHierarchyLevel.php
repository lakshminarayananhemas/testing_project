<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesHierarchyLevel extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_code',
        'level_code',
        'level_name',
    ];
}
