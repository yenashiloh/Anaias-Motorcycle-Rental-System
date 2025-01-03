<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $primaryKey = 'reservation_id';

    protected $fillable = [
        'customer_id',
        'driver_id', 
        'rental_start_date',
        'rental_end_date',
        'pick_up',
        'drop_off',
        'riding',
        'total',
        'motor_id',
        'violation_status',
        'cancel_reason',
        'decline_reason'
    ];

    public function cancelReservation($reason)
    {
        $this->status = 'Cancelled';
        $this->cancel_reason = $reason;
        $this->save();
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class, 'motor_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'reservation_id');
    }

    public function driverInformation() 
    {
        return $this->belongsTo(DriverInformation::class, 'driver_id', 'driver_id');
    }
    public function penalty()
    {
        return $this->belongsTo(Penalty::class, 'reservation_id', 'reservation_id');
    }

    public function penaltyPayment()
    {
        return $this->hasOne(PenaltyPayment::class, 'reservation_id', 'reservation_id');
    }

}
