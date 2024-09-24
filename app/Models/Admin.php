<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    
    protected $table = 'admins';

    protected $primaryKey = 'admin_id';

    public $timestamps = true;

    protected $fillable = [
        
        'first_name',
        'last_name',
        'contact_number',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
