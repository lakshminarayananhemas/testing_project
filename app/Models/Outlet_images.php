<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet_images extends Model
{
    use HasFactory;
    protected $fillable = [
        'auto_id',
        'cg_id',
        'image_name',
        'created_by',
        'modified_by',
    ];
}
