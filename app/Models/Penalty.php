<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $table = 'penalty';

    // protected $primaryKey = 'penalty_id';

    // public $incrementing = true;

    protected $fillable = [
        'penalty_id',
        'reservation_id',
        'customer_id',
        'driver_id',
        'penalty_type',
        'description',
        'additional_payment',
        'penalty_image',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'penalty_image' => 'array',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function driver()
    {
        return $this->belongsTo(DriverInformation::class, 'driver_id');
    }

    public function penaltyPayment()
    {
        return $this->hasOne(PenaltyPayment::class, 'penalty_id', 'penalty_id');
    }

}
