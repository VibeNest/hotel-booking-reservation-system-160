<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    // Room Type List Method
    public function RoomTypeList()
    {
        $allData = RoomType::orderBy('id', 'desc')->get();
        return view('backend.all_room.room_type.room_type_list', compact('allData'));
    }
}
