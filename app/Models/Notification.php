<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications'; 
    protected $fillable = [
        'customer_id', 
        'reservation_id',
        'type',
        'message',
        'read', 
    ];
    protected $casts = [
        'read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
