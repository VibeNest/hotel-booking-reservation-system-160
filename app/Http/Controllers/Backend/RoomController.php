<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\Room;
use App\Models\RoomNumber;
use App\Models\RoomType;
use App\Services\ImageUploadProxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function __construct(
        protected ImageUploadProxy $imageProxy
    ) {}

    // Edit Room Method
    public function EditRoom($id)
    {
        $basic_facility = Facility::where('rooms_id', $id)->get();
        $multi_images = MultiImage::where('rooms_id', $id)->get();
        $editData = Room::find($id);
        $roomNumbers = RoomNumber::where('rooms_id', $id)->get();

        return view('backend.all_room.rooms.edit_room', compact('editData', 'basic_facility', 'multi_images', 'roomNumbers'));
    }

    // Update Room Method
    public function UpdateRoom(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        // =============================
        // VALIDATE
        // =============================
        if (empty($request->facility_name)) {
            return redirect()->back()->with([
                'message' => 'Sorry! Not Any Basic Facility Select',
                'alert-type' => 'error',
            ]);
        }

        // =============================
        // TRANSACTION (safe cho test)
        // =============================
        DB::transaction(function () use ($request, $room) {

            // =============================
            // DATA
            // =============================
            $data = [
                'roomtype_id' => $request->roomtype_id,
                'total_adult' => $request->total_adult,
                'total_child' => $request->total_child,
                'room_capacity' => $request->room_capacity,
                'price' => $request->price,
                'size' => $request->size,
                'view' => $request->view,
                'bed_style' => $request->bed_style,
                'discount' => $request->discount ?? 0,
                'short_desc' => $request->short_desc,
                'description' => $request->description,
                'status' => 1,
            ];

            // =============================
            // MAIN IMAGE
            // =============================
            if ($request->hasFile('image')) {

                // xóa ảnh cũ
                if (! empty($room->image)) {
                    $this->imageProxy->delete('upload/room_images/' . $room->image);
                }

                $image = $request->file('image');
                $name = uniqid() . '.' . $image->getClientOriginalExtension();

                if (app()->environment('testing')) {
                    $this->imageProxy->move($image, 'upload/room_images', $name);
                } else {
                    $this->imageProxy->upload($image, 'upload/room_images', 550, 850, 'cover', $name);
                }

                $data['image'] = $name;
            }

            $room->update($data);

            // =============================
            // FACILITY
            // =============================
            Facility::where('rooms_id', $room->id)->delete();

            foreach ($request->facility_name as $item) {
                Facility::create([
                    'rooms_id' => $room->id,
                    'facility_name' => $item,
                ]);
            }

            // =============================
            // MULTI IMAGE
            // =============================
            if ($request->hasFile('multi_img')) {

                // Xóa ảnh cũ (file + DB)
                $oldImgs = MultiImage::where('rooms_id', $room->id)->get();

                foreach ($oldImgs as $img) {
                    $this->imageProxy->delete($img->multi_img);
                }

                MultiImage::where('rooms_id', $room->id)->delete();

                // Lưu ảnh mới
                foreach ($request->file('multi_img') as $img) {

                    $name = uniqid() . '.' . $img->getClientOriginalExtension();
                    $this->imageProxy->move($img, 'upload/room_images/multi_img', $name);

                    MultiImage::create([
                        'rooms_id' => $room->id,
                        'multi_img' => 'upload/room_images/multi_img/' . $name,
                    ]);
                }
            }
        });

        return redirect()->route('room.type.list')->with([
            'message' => 'Update Room Successfully',
            'alert-type' => 'success',
        ]);
    }

    // Delete Room Method
    public function DeleteRoom(Request $request, $id)
    {
        $room = Room::find($id);

        // Xóa ảnh chính của phòng nếu tồn tại
        if (! empty($room->image)) {
            $this->imageProxy->delete('upload/room_images/' . $room->image);
        }

        // Xóa ảnh phụ của phòng nếu tồn tại
        $multiImages = MultiImage::where('rooms_id', $room->id)->get()->toArray();

        if (! empty($multiImages)) {
            foreach ($multiImages as $img) {
                if (! empty($img)) {
                    $this->imageProxy->delete($img['multi_img']);
                }
            }
        }

        // Xóa loại phòng trong db
        RoomType::where('id', $room->roomtype_id)->delete();

        // Xóa gallery ảnh phụ trong db
        MultiImage::where('rooms_id', $room->id)->delete();

        // Xóa facility trong db
        Facility::where('rooms_id', $room->id)->delete();

        // Xóa số phòng trong db
        RoomNumber::where('rooms_id', $room->id)->delete();

        // Xóa phòng trong db
        $room->delete();

        // Hiển thị thông báo xóa thành công
        $notification = [
            'message' => 'Deleted Room Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Multi Image Delete Method
    public function MultiImageDelete($id)
    {
        $deleteData = MultiImage::where('id', $id)->first();

        if ($deleteData) {
            $this->imageProxy->delete($deleteData->multi_img);

            // Xóa bản ghi trong database
            $deleteData->delete();
        }

        $notification = [
            'message' => 'Deleted Multi Image Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Store Room Number Method
    public function StoreRoomNumber(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required',
            'status' => 'required',
        ]);

        $room = Room::find($id);

        if (! $room) {
            return redirect()->back()->with([
                'message' => 'Room Not Found',
                'alert-type' => 'error',
            ]);
        }

        RoomNumber::create([
            'rooms_id' => $room->id,
            'room_type_id' => $room->roomtype_id,
            'room_number' => $request->room_number,
            'status' => $request->status,
        ]);

        return redirect()->back()->with([
            'message' => 'Added Room Number Successfully',
            'alert-type' => 'success',
        ]);
    }

    // Edit Room Number Method
    public function EditRoomNumber($id)
    {
        $editData = RoomNumber::findOrFail($id);

        return view('backend.all_room.rooms.edit_room_number', compact('editData'));
    }

    // Update Room Number Method
    public function UpdateRoomNumber(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required',
            'status' => 'required',
        ]);

        $roomNumber = RoomNumber::findOrFail($id);

        $roomNumber->update([
            'room_number' => $request->room_number,
            'status' => $request->status,
        ]);

        return redirect()->route('edit.room', $roomNumber->rooms_id)
            ->with([
                'message' => 'Update Room Number Successfully',
                'alert-type' => 'success',
            ]);
    }

    // Delete Room Number Method
    public function DeleteRoomNumber($id)
    {
        $roomNumber = RoomNumber::find($id);

        if (! $roomNumber) {
            return redirect()->back()->with([
                'message' => 'Room Number Not Found',
                'alert-type' => 'error',
            ]);
        }

        $roomNumber->delete();

        return redirect()->back()->with([
            'message' => 'Deleted Room Number Successfully',
            'alert-type' => 'success',
        ]);
    }
}
