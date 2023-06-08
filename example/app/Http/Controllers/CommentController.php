<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(Request $request, Post $post)
    {
        $post->comments()->create([
            "user_id" => auth()->user()->id,
            "text" => $request->text,
        ]);
        return redirect()->route('single', $post->id);

    }
}
