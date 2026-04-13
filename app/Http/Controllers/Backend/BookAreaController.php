<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BookArea;
use Illuminate\Http\Request;

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
}
