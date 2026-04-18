<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Edit Room Method
    public function EditRoom($id)
    {
        $editData = Room::find($id);
        return view('backend.all_room.rooms.edit_room', compact('editData'));
    }
}
