<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRoomList extends Model
{
    protected $guarded = [];

    public function room_numbers()
    {
        return $this->belongsTo(RoomNumber::class, 'room_number_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
