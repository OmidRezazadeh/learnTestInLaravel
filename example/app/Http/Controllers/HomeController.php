<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $posts = Post::latest()->paginate(15);
        return view('welcome', compact('posts'));
    }

    public function single(Post $post)
    {
        $comments = $post
            ->comments()
            ->latest()
            ->paginate(15);
        return view('single', compact('post','comments'));
    }
}
