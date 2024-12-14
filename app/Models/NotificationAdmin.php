<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationAdmin extends Model
{
    use HasFactory;

    protected $table = 'notifications_admin';

    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'reservation_id',
        'type',
        'message',
        'read',
    ];

    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}