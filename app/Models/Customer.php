<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class Customer extends Authenticatable implements CanResetPasswordContract
{
    use HasFactory, Notifiable, CanResetPassword;
    

    protected $table = 'customers'; 
    
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'email',
        'password',
        'otp',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function driverInformation()
    {
        return $this->hasOne(DriverInformation::class, 'customer_id', 'customer_id');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'customer_id', 'customer_id');
    }

}


