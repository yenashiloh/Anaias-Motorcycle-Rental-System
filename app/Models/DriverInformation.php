<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverInformation extends Model
{
    use HasFactory;

    protected $table = 'driver_information';

    protected $primaryKey = 'driver_id';

    protected $fillable = [
        'customer_id', 
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'address',
        'birthdate',
        'gender',
        'driver_license',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


    
}
