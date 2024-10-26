<?php

namespace App\Http\Controllers;

use App\Models\Post; // Import the Post model
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function postCreatePost(Request $request)
    {
        $post = new Post();
        $post->body = $request['body'];
        $post->image = $request['image'];
        
        $request->user()->posts()->save($post);

        return redirect()->route('home');
    }

    public function fetchData()
    {
        // Get all records from the model
        $data = Post::all();

        return response()->json($data);
    }
}

?>