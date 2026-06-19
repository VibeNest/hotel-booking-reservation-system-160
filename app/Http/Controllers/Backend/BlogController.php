<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Services\ImageUploadProxy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function __construct(
        protected ImageUploadProxy $imageProxy
    ) {}

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
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Added blog category successfully!',
            'alert-type' => 'success',
        ];

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

        $notification = [
            'message' => 'Updated blog category successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // Delete Blog Category Method
    public function DeleteBlogCategory($id)
    {
        BlogCategory::find($id)->delete();

        $notification = [
            'message' => 'Deleted blog category successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // All Blog Post Method
    public function AllBlogPost()
    {
        $post = BlogPost::latest()->get();

        return view('backend.post.all_post', compact('post'));
    }

    // Add Blog Post Method
    public function AddBlogPost()
    {
        $blog_cat = BlogCategory::latest()->get();

        return view('backend.post.add_post', compact('blog_cat'));
    }

    // Store Blog Post Method
    public function StoreBlogPost(Request $request)
    {
        $request->validate([
            'post_title' => 'required|string',
            'short_desc' => 'required|string',
            'long_desc' => 'required|string',
            'post_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image = $request->file('post_image');
        $save_url = 'upload/posts/' . $this->imageProxy->upload($image, 'upload/posts', 550, 370);

        // Lưu thông tin post vào database
        BlogPost::insert([
            'blog_cat_id' => $request->blog_cat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Added Blog Post Successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.blog.post')->with($notification);
    }

    // Edit Blog Post Method
    public function EditBlogPost($id)
    {
        $blog_cat = BlogCategory::latest()->get();
        $post = BlogPost::find($id);

        return view('backend.post.edit_post', compact('blog_cat', 'post'));
    }

    // Update Blog Post Method
    public function UpdateBlogPost(Request $request)
    {
        $post_id = $request->id;
        $post = BlogPost::findOrFail($post_id);

        if ($request->file('post_image')) {
            $this->imageProxy->delete($post->post_image);

            $image = $request->file('post_image');
            $save_url = 'upload/posts/' . $this->imageProxy->upload($image, 'upload/posts', 550, 370);

            // Cập nhật thông tin post vào database khi thay đổi ảnh
            BlogPost::findOrFail($post_id)->update([
                'blog_cat_id' => $request->blog_cat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,
                'post_image' => $save_url,
            ]);

            // Hiển thị thông báo toaster
            $notification = [
                'message' => 'Updated post with image successfully!',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.blog.post')->with($notification);
        } else {
            // Cập nhật thông tin post vào database mà không thay đổi ảnh
            BlogPost::findOrFail($post_id)->update([
                'blog_cat_id' => $request->blog_cat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,
            ]);

            // Hiển thị thông báo toaster
            $notification = [
                'message' => 'Updated post without image successfully!',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.blog.post')->with($notification);
        }
    }

    // Delete Blog Post Method
    public function DeleteBlogPost($id)
    {
        $item = BlogPost::findOrFail($id);
        $this->imageProxy->delete($item->post_image);

        BlogPost::findOrFail($id)->delete();

        // Hiển thị thông báo toaster
        $notification = [
            'message' => 'Deleted post successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
