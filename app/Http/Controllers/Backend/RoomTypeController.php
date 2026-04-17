<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    // Room Type List Method
    public function RoomTypeList()
    {
        $allData = RoomType::orderBy('id', 'desc')->get();
        return view('backend.all_room.room_type.room_type_list', compact('allData'));
    }

    // Add Room Type Method
    public function AddRoomType()
    {
        return view('backend.all_room.room_type.add_room_type');
    }

    // Store Room Type Method
    public function RoomTypeStore(Request $request)
    {
        $roomtype_id = RoomType::insertGetId([
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

        Room::insert([
            'roomtype_id' => $roomtype_id,
        ]);

        $notification = array(
            'message' => 'Added room type successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('room.type.list')->with($notification);
    }
}
