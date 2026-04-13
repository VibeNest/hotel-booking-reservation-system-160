<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BookArea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BookAreaController extends Controller
{
    //All Book Area Method
    public function AllBookArea()
    {
        $bookArea = BookArea::latest()->get();
        return view('backend.book_area.all_book_area', compact('bookArea'));
    }

    //Add Book Area Method
    public function AddBookArea()
    {
        return view('backend.book_area.add_book_area');
    }

    //Store Book Area Method
    public function StoreBookArea(Request $request)
    {
        // Xử lý upload ảnh
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);
        $img->resize(576, 576)->save(public_path('upload/book_area/' . $name_gen));
        $save_url = 'upload/book_area/' . $name_gen;

        // Lưu thông tin book area vào database
        BookArea::insert([
            'sub_title' => $request->sub_title,
            'title' => $request->title,
            'description' => $request->description,
            'link_url' => $request->link_url,
            'image' => $save_url,
            'created_at' => Carbon::now()
        ]);

        // Hiển thị thông báo toaster
        $notification = array(
            'message' => 'Added book area successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.book.area')->with($notification);
    }

    //Edit Book Area Method
    public function EditBookArea($id)
    {
        $bookArea = BookArea::findOrFail($id);
        return view('backend.book_area.edit_book_area', compact('bookArea'));
    }

    //Update Book Area Method
    public function UpdateBookArea(Request $request)
    {
        $bookArea_id = $request->id;
        $bookArea = BookArea::findOrFail($bookArea_id);

        if ($request->file('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($bookArea->image && file_exists(public_path($bookArea->image))) {
                unlink(public_path($bookArea->image));
            }

            // Xử lý upload ảnh mới
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(576, 576)->save(public_path('upload/book_area/' . $name_gen));
            $save_url = 'upload/book_area/' . $name_gen;

            // Cập nhật thông tin book area vào database khi thay đổi ảnh
            BookArea::findOrFail($bookArea_id)->update([
                'sub_title' => $request->sub_title,
                'title' => $request->title,
                'description' => $request->description,
                'link_url' => $request->link_url,
                'image' => $save_url,
                'created_at' => Carbon::now()
            ]);

            // Hiển thị thông báo toaster
            $notification = array(
                'message' => 'Updated book area with image successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.book.area')->with($notification);
        } else {
            // Cập nhật thông tin book area vào database mà không thay đổi ảnh
            BookArea::findOrFail($bookArea_id)->update([
                'sub_title' => $request->sub_title,
                'title' => $request->title,
                'description' => $request->description,
                'link_url' => $request->link_url,
                'created_at' => Carbon::now()
            ]);

            // Hiển thị thông báo toaster
            $notification = array(
                'message' => 'Updated book area without image successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.book.area')->with($notification);
        }
    }

    //Delete Book Area Method
    public function DeleteBookArea($id)
    {
        $item = BookArea::findOrFail($id);
        $img = $item->image;
        unlink($img);

        BookArea::findOrFail($id)->delete();

        // Hiển thị thông báo toaster
        $notification = array(
            'message' => 'Deleted book area successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
}
