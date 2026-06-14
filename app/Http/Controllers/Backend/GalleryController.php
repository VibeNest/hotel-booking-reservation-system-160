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
}
