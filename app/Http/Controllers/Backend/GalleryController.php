<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // All Gallery Method
    public function AllGallery()
    {
        $gallery = Gallery::latest()->get();

        return view('backend.gallery.all_gallery', compact('gallery'));
    }
}
