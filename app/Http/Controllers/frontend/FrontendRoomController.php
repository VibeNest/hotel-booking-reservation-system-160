<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Facility;
use App\Models\MultiImage;
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
    public function RoomDetailsPage($id)
    {
        $room = Room::findOrFail($id);

        $facilities = Facility::where('rooms_id', $id)->get();
        $multiImages = MultiImage::where('rooms_id', $id)->get();

        return view('frontend.room.room_details', compact(
            'room',
            'facilities',
            'multiImages'
        ));
    }
}
