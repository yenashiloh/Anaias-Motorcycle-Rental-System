<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
use HasFactory;

    protected $primaryKey = 'motor_id';
    
    protected $fillable = [
        'name',
        'brand',
        'model',
        'cc',
        'year',
        'gas',
        'color',
        'body_number',
        'plate_number',
        'price',
        'description',
        'images',
        'status'
    ];
}
