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
        'status',
        'engine_status', 
        'brake_status', 
        'tire_condition', 
        'oil_status', 
        'lights_status', 
        'overall_condition'
    ];

    
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'motor_id');
    }
}
