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
        'rental_start_date',
        'rental_end_date',
        'pick_up',
        'drop_off',
        'riding',
        'total',
        'motor_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class, 'motor_id');
    }
}
