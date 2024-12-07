<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyPayment extends Model
{
    use HasFactory;

    protected $table = 'penalty_payments';  

    protected $primaryKey = 'penalty_payment_id';  

    protected $fillable = [
        'penalty_id',
        'customer_id',
        'driver_id',
        'reservation_id',
        'payment_method',
        'gcash_name',
        'gcash_number',
        'image_receipt',
    ];

    public function penalty()
    {
        return $this->belongsTo(Penalty::class, 'penalty_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function driver()
    {
        return $this->belongsTo(DriverInformation::class, 'driver_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}