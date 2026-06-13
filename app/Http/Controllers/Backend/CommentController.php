<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Store Comment Method
    public function StoreComment(Request $request)
    {
        Comment::insert([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Added comment successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    // All Comment Method
    public function AllComment()
    {
        $allComment = Comment::latest()->get();

        return view('backend.comment.all_comment', compact('allComment'));
    }

    // Update Comment Status Method
    public function UpdateCommentStatus(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $is_checked = $request->input('is_checked', 0);

        $comment = Comment::find($comment_id);
        if ($comment) {
            $comment->status = $is_checked;
            $comment->save();
        }

        return response()->json(['message' => 'Updated Status Comment Successfully']);
    }
}
