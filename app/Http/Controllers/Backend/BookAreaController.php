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
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);
        $img->resize(576, 576)->save(public_path('upload/book_area/' . $name_gen));
        $save_url = 'upload/book_area/' . $name_gen;

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
            'message' => 'Added Book Area successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.book.area')->with($notification);
    }
}
