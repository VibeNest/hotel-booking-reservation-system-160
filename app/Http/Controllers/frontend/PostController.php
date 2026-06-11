<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Blog Details Method
    public function BlogDetails($slug)
    {
        $blog = BlogPost::where('post_slug', $slug)->first();
        $blog_cat = BlogCategory::latest()->get();
        $otherPost = BlogPost::where('post_slug', '!=', $slug)->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.blog.blog_details', compact('blog', 'blog_cat', 'otherPost'));
    }

    // Blog Category List Method
    public function BlogCategoryList($id)
    {
        $blog = BlogPost::where('blog_cat_id', $id)->get();
        $blog_cat = BlogCategory::latest()->get();
        $blog_cat_name = BlogCategory::where('id', $id)->first();
        $otherPost = BlogPost::where('id', '!=', $id)->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.blog.blog_category_list', compact('blog', 'blog_cat', 'otherPost', 'blog_cat_name'));
    }

    // Blog List Method
    public function BlogList()
    {
        $blog = BlogPost::latest()->paginate(3);
        $blog_cat = BlogCategory::latest()->get();
        $otherPost = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_all', compact('blog', 'blog_cat', 'otherPost'));
    }
}
