<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class FrontendRoomController extends Controller
{
    // Frontend Room All Method
    public function AllFrontendRoomList()
    {
        $rooms = Room::latest()->get();
        return view('frontend.room.all_rooms', compact('rooms'));
    }

    // Frontend Room Details Method
    public function RoomDetailsPage()
    {
        return view('frontend.room.room_details');
    }
}
