<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomNumber extends Model
{
    protected $guarded = [];

    public function room_type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function last_booking()
    {
        return $this->hasOne(BookingRoomList::class, 'room_number_id')->latest();
    }
}
