<?php

namespace App\Http\Controllers;

use App\Models\Post; // Import the Post model
use Illuminate\Http\Request;
use App\Models\Comment;

class PostController extends Controller
{
    public function postCreatePost(Request $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts_images', 'public');
        }
    
        $post = new Post();
        $post->body = $request->input('body');
        $post->image = $imagePath;
        $request->user()->posts()->save($post);
    
        return redirect()->route('home');
    }

    public function fetchPosts()
    {
        // Get all records from the model
        $data = Post::with('user')->get();

        $current_user_id = session('id');

        return response()->json([
            'post' => $data,
            'currentUserId' => $current_user_id
        ]);
    }

    public function fetchComments($postId)
    {
        // Retrieve the comments and associated post data
        $comments = Comment::where('post_id', $postId)->with('user')->get();
        $post = Post::find($postId); // Retrieve the post itself

        return response()->json([
            'comments' => $comments,
            'post' => $post
        ]);
    }

    public function addComment()
    {
        $post = Post::find(1); // Find the post
        $comment = new Comment();
        $comment->body = 'This is a comment.';
        $comment->user()->associate(auth()->user()); // Associate with the current user
        $post->comments()->save($comment); // Save the comment
    }
}

?>