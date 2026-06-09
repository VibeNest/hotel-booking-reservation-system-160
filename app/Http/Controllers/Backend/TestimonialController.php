<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TestimonialController extends Controller
{
    // All Testimonial Method
    public function AllTestimonial()
    {
        $testimonial = Testimonial::latest()->get();
        return view('backend.testimonial.all_testimonial', compact('testimonial'));
    }

    // Add Testimonial Method
    public function AddTestimonial()
    {
        return view('backend.testimonial.add_testimonial');
    }

    // Testimonial Store Method
    public function TestimonialStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Xử lý upload ảnh
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);
        $img->resize(50, 50)->save(public_path('upload/testimonials/' . $name_gen));
        $save_url = 'upload/testimonials/' . $name_gen;

        // Lưu thông tin book area vào database
        Testimonial::insert([
            'name' => $request->name,
            'city' => $request->city,
            'message' => $request->message,
            'image' => $save_url,
            'created_at' => Carbon::now()
        ]);

        // Hiển thị thông báo toaster
        $notification = array(
            'message' => 'Added testimonial successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonial')->with($notification);
    }

    // Edit Testimonial Method
    public function EditTestimonial($id)
    {
        $testimonial = Testimonial::find($id);
        return view('backend.testimonial.edit_testimonial', compact('testimonial'));
    }

    // Testimonial Update Method
    public function TestimonialUpdate(Request $request)
    {
        $testimonial_id = $request->id;
        $testimonial = Testimonial::findOrFail($testimonial_id);

        if ($request->file('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                unlink(public_path($testimonial->image));
            }

            // Xử lý upload ảnh mới
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(50, 50)->save(public_path('upload/testimonials/' . $name_gen));
            $save_url = 'upload/testimonials/' . $name_gen;

            // Cập nhật thông tin book area vào database khi thay đổi ảnh
            Testimonial::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'city' => $request->city,
                'message' => $request->message,
                'image' => $save_url,
                'created_at' => Carbon::now()
            ]);

            // Hiển thị thông báo toaster
            $notification = array(
                'message' => 'Updated testimonial with image successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.testimonial')->with($notification);
        } else {
            // Cập nhật thông tin book area vào database mà không thay đổi ảnh
            Testimonial::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'city' => $request->city,
                'message' => $request->message,
                'created_at' => Carbon::now()
            ]);

            // Hiển thị thông báo toaster
            $notification = array(
                'message' => 'Updated testimonial without image successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.testimonial')->with($notification);
        }
    }
}
