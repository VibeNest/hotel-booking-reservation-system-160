<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class RoomController extends Controller
{
    // Edit Room Method
    public function EditRoom($id)
    {
        $basic_facility = Facility::where('rooms_id', $id)->get();
        $editData = Room::find($id);
        return view('backend.all_room.rooms.edit_room', compact('editData', 'basic_facility'));
    }

    // Update Room
    public function UpdateRoom(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $data = [
            'total_adult' => $request->total_adult,
            'total_child' => $request->total_child,
            'room_capacity' => $request->room_capacity,
            'price' => $request->price,
            'size' => $request->size,
            'view' => $request->view,
            'bed_style' => $request->bed_style,
            'discount' => $request->discount,
            'short_desc' => $request->short_desc,
            'description' => $request->description,
        ];


        if ($request->file('image')) {


            if (!empty($room->image) && File::exists(public_path('upload/room_images/' . $room->image))) {
                File::delete(public_path('upload/room_images/' . $room->image));
            }

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();


            $folder = public_path('upload/room_images');
            File::ensureDirectoryExists($folder);


            $manager = new ImageManager(new Driver());
            $manager->read($image)
                ->cover(550, 850)
                ->save($folder . '/' . $name_gen);

            $data['image'] = $name_gen;
        }


        $room->update($data);

        return redirect()->route('room.type.list')->with([
            'message' => 'Update Room Successfully',
            'alert-type' => 'success'
        ]);
    }
}
