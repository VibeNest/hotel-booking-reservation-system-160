<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleryController extends Controller
{
    // All Gallery Method
    public function AllGallery()
    {
        $gallery = Gallery::latest()->get();

        return view('backend.gallery.all_gallery', compact('gallery'));
    }

    // Add Gallery Method
    public function AddGallery()
    {
        return view('backend.gallery.add_gallery');
    }

    // Store Gallery Method
    public function StoreGallery(Request $request)
    {
        $images = $request->file('photo_name');

        foreach ($images as $image) {
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(550, 550)->save(public_path('upload/gallery/' . $name_gen));
            $save_url = 'upload/gallery/' . $name_gen;

            Gallery::insert([
                'photo_name' => $save_url,
                'created_at' => Carbon::now()
            ]);
        }

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Added gallery successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.gallery')->with($notification);
    }

    // Edit Gallery Method
    public function EditGallery($id)
    {
        $gallery = Gallery::find($id);

        return view('backend.gallery.edit_gallery', compact('gallery'));
    }

    // Update Gallery Method
    public function UpdateGallery(Request $request)
    {
        $gallery_id = $request->id;
        $gallery = Gallery::findOrFail($gallery_id);

        if ($request->file('photo_name')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($gallery->photo_name && file_exists(public_path($gallery->photo_name))) {
                unlink(public_path($gallery->photo_name));
            }

            $image = $request->file('photo_name');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(550, 550)->save(public_path('upload/gallery/' . $name_gen));
            $save_url = 'upload/gallery/' . $name_gen;

            Gallery::find($gallery_id)->update([
                'photo_name' => $save_url,
            ]);

            // Hiển thị thông báo toaster
            $notification = [
                'message' => 'Updated gallery successfully!',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.gallery')->with($notification);
        }
    }

    // Delete Gallery Method
    public function DeleteGallery($id)
    {
        $item = Gallery::findOrFail($id);
        $img = $item->photo_name;
        unlink($img);

        Gallery::findOrFail($id)->delete();

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Deleted gallery successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Delete Gallery Multiple Method
    public function DeleteGalleryMultiple(Request $request)
    {
        $selectedItems = $request->input('selectedItem', []);

        foreach ($selectedItems as $itemId) {
            $item = Gallery::find($itemId);
            $img = $item->photo_name;
            unlink($img);
            $item->delete();
        }

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Deleted image selected successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
