<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'customer_id',
        'reservation_id',
        'motor_id', 
        'booking_id',
        'name',
        'number',
        'receipt',
        'amount',
        'image',
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
