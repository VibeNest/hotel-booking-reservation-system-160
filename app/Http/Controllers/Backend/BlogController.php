<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Blog Category Method
    public function BlogCategory()
    {
        $category = BlogCategory::latest()->get();
        return view('backend.category.blog_category', compact('category'));
    }

    // Store Blog Category Method
    public function StoreBlogCategory(Request $request)
    {
        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        $notification = array(
            'message' => 'Added blog category successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // Edit Blog Category Method
    public function EditBlogCategory($id)
    {
        $categories = BlogCategory::find($id);

        return response()->json($categories);
    }

    // Update Blog Category Method
    public function UpdateBlogCategory(Request $request)
    {
        $cat_id = $request->cat_id;

        BlogCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        $notification = array(
            'message' => 'Updated blog category successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
