<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post; // Import the Post model
use App\Models\Heart;
use App\Models\Share;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log; 

class PostController extends Controller
{
    public function postCreatePost(Request $request)
    {
        try {
            // Get user ID from session
            $userId = session('id');
            if (!$userId) {
                return redirect()->route('home')->with('error', 'User not authenticated');
            }

            // Find the user
            $user = User::find($userId);
            if (!$user) {
                return redirect()->route('home')->with('error', 'User not found');
            }

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('posts_images', 'public');
            }
        
            // Create post through user relationship
            $post = $user->posts()->create([
                'body' => $request->input('body'),
                'image' => $imagePath
            ]);
        
            return redirect()->route('home');

        } catch (\Exception $e) {
            Log::error('Post creation error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Error creating post');
        }
    }

    public function fetchPosts()
    {

        $current_user_id = session('id');
        
        // Get all records from the model
        $data = Post::with(['user' => function($query) {
            $query->select('id', 'profile_picture', 'name');
        }, 'shares.user' => function($query) {
            $query->select('id', 'name', 'profile_picture');
        }])->get();

        foreach ($data as $post) {
            $heart = Heart::where('user_id', $current_user_id)
                          ->where('post_id', $post->id) // Specify each post's ID
                          ->exists(); // Check if a heart exists

            $numberOfHearts = Heart::where('post_id', $post->id)->count();
        
            // Add a custom property to indicate if the current user has hearted the post
            $post->isHeartedByCurrentUser = $heart;
            $post->numberOfHearts = $numberOfHearts;

            if ( sizeof($post->shares) > 0 )
            {
                foreach ( $post->shares as $share )
                {
                    $heart = Heart::where('user_id', $current_user_id)
                                    ->where('share_id', $share->id) // Specify each post's ID
                                    ->exists();

                    $numberOfHearts = Heart::where('share_id', $share->id)->count();

                    $share->isHeartedByCurrentUser = $heart;
                    $share->numberOfHearts = $numberOfHearts ;
                }
            }
        }

        return response()->json([
            'post' => $data,
            'heart' => $heart,
            'currentUserId' => $current_user_id
        ]);
    }

    public function fetchComments($postId, $shareId)
    {
        if ( $shareId == 'null' )
        {
            // Retrieve the comments and associated post data
            $comments = Comment::where('post_id', $postId)->with('user')->get();
            $post = Post::find($postId); // Retrieve the post itself
            $creator = $post->user;
            $current_user_id = session('id');

            return response()->json([
                'comments' => $comments,
                'post' => $post,
                'creator' => $creator,
                'current_user_id' => $current_user_id
            ]);
        }
        else
        {
            // Retrieve the comments and associated post data
            $comments = Comment::where('share_id', $shareId)->with('user')->get();
            $share = Share::find($shareId); // Retrieve the share itself
            $creator = $share->user;
            $post = $share->post;
            $current_user_id = session('id');

            return response()->json([
                'comments' => $comments,
                'post' => ['share' => $share, 'origin_post' => $post],
                'creator' => $creator,
                'current_user_id' => $current_user_id
            ]);
        }
    } 

    public function createComment(Request $request, $postId, $shareId)
    {
        if ( $shareId == 'null' )
        {
            $post = Post::find($postId); // Find the post
            $comment = new Comment();
            $comment->post_id = (int) $postId;
            $comment->share_id = null;
            $comment->body = $request->input('commentBody');
            $comment->user()->associate(auth()->user()); // Associate with the current user
            $post->comments()->save($comment); // Save the comment
        }
        else
        {
            $share = Share::find($shareId); // Find the share
            $comment = new Comment();
            $comment->post_id = null;
            $comment->share_id = (int) $shareId;
            $comment->body = $request->input('commentBody');
            $comment->user()->associate(auth()->user()); // Associate with the current user
            $share->comments()->save($comment); // Save the comment
        }

        return $this->fetchComments($postId, $shareId);
        // return redirect()->route('fetchComments', ['post' => $postId, 'share_id' => $shareId]);
    }

    public function retrievePostData(Request $request, $postId)
    {
        $request->validate([
            'sharedpost_id' => 'nullable|int'
        ]);

        $shareId = $request->input('sharedpost_id');

        // echo "
        //     <script>
        //         console.log('Post ID: $postId');
        //         console.log('Shared Post ID: " . $request->input('sharedpost_id') . "');
        //     </script>
        // ";

        if ($postId == 'null') {
            $post = Share::find($request->input('sharedpost_id'));
        } else {
            $post = Post::find($postId);
        }

        if (!$post) {
            return response()->json(['sharedPostData' => $shareId]);
        }

        return response()->json(['postData' => $post]);
    }
    
    public function editPostCaption($postId, Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'ifShared' => 'nullable|int'
        ]);

        $sharedId = $request->input('ifShared');

        if ( !$sharedId || $sharedId < 1)
        {
            $post = Post::findOrFail($postId);
            $post->body = $request->input('body');
            $post->save();
            return response()->json(['postData' => $post]);
        }

        $share = Share::findOrFail($postId);
        $share->body = $request->input('body');
        $share->save();

        return response()->json(['sahredpostData' => $share]);
        
    }

    public function deletePost(Request $request)
    {
        $request->validate([
            'post' => 'nullable|integer',
            'share_id' => 'nullable|integer'
        ]);

        try {
            if ($request->filled('share_id')) {
                // Delete share
                $share = Share::where('id', $request->share_id)
                             ->where('user_id', session('id'))
                             ->firstOrFail();
                $share->delete();
            } else {
                // Delete post
                $post = Post::where('id', $request->post)
                           ->where('user_id', session('id'))
                           ->firstOrFail();
                $post->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete post error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting post: ' . $e->getMessage()
            ], 500);
        }
    }

    function editCommentBTN(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        return response()->json(['comment' => $comment]);
    }

    function editComment(Request $request, $commentId)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        $comment = Comment::findOrFail($commentId);
        $comment->body = $request->input('body');
        $comment->save();

        return response()->json(['comment' => $comment]);
    }

    function deleteComment(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        return response()->json(['message' => 'successful']);
    }

    function heart(Request $request, $postId)
    {
        $postId = (int) $postId;

        $request->validate([
            'share_id' => 'nullable|int',
            'post_type' => 'required|string'
        ]);

        $userId = session('id');
        $shareId = (int) $request->input('share_id');

        $query = Heart::where('user_id', $userId);

        if (!$shareId)
        {
            $query->where('post_id', $postId);
        } else
        {
            $query->where('share_id', $shareId);
        }

        $heart = $query->first();
        
        if($heart)
        {
            return $this->unheart($postId, $shareId, $heart->id);
        }

        $create_heart = Heart::create([
            'post_id' => $request->input('share_id') ? null : $postId,
            'share_id' => $request->input('share_id') ?: null,
            'user_id' => $userId,
            'post_type' => $request->input('post_type')
        ]);

        $numberOfHearts = $request->input('share_id') ? Heart::where('share_id', $request->input('share_id'))->count() : Heart::where('post_id', $postId)->count();

        return response()->json([
            'heart' => $create_heart,
            'numberOfHearts' => $numberOfHearts
        ]);
    }

    function unheart($postId, $shareId, $heartId)
    {
        // Delete the heart entry by its ID
        $heart = Heart::where('id', $heartId)->delete();

        $numberOfHearts = $shareId ? Heart::where('share_id', $shareId)->count() : Heart::where('post_id', $postId)->count();

        return response()->json([
            'heart' => $heart, // Since we unhearted, there's no active heart entry
            'numberOfHearts' => $numberOfHearts,
            'heart_id' => $heartId
        ]);
    }

    function share(Request $request)
    {
        $request->validate([
            'post_id' => 'required|int',
            'body' => 'nullable|string'
        ]);

        try {
            $userId = session('id');
            $postId = (int) $request->input('post_id');

            // Find the post with its user relationship
            $post = Post::with('user')->findOrFail($postId);

            // Create the share with relationship loading
            $share = Share::create([
                'post_id' => $postId,
                'user_id' => $userId,
                'body' => $request->input('body')
            ]);

            // Load necessary relationships
            $share->load('user');

            // Get heart count and status
            $isHeartedByCurrentUser = Heart::where('share_id', $share->id)
                                         ->where('user_id', $userId)
                                         ->exists();
            $numberOfHearts = Heart::where('share_id', $share->id)->count();

            $share->isHeartedByCurrentUser = $isHeartedByCurrentUser;
            $share->numberOfHearts = $numberOfHearts;

            return response()->json([
                'success' => true,
                'share' => $share,
                'post' => $post,
                'sharer' => User::find($userId),
                'postOwner' => $post->user,
                'currentUser' => $userId
            ]);

        } catch (\Exception $e) {
            Log::error('Share error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sharing post'
            ], 500);
        }
    }
}

?>