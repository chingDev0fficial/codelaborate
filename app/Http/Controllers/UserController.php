<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function fetchUserProfile(Request $request)
    {
        try {
            $user = User::find($request->id);
            
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Get follow status
            $isFollowing = Follow::where('follower_id', session('id'))
                                ->where('following_id', $request->id)
                                ->exists();

            $userData = $user->toArray();
            $userData['isFollowing'] = (bool) $isFollowing;

            return response()->json($userData);
        } catch (\Exception $e) {
            \Log::error('Error in fetchUserProfile: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching profile'], 500);
        }
    }

    public function userProfile()
    {
        return view('profilepage');
    }

    public function signup(Request $request)
    {
        // Validate the form input
        try
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'birthday' => 'required|date|before:today',
                'sex' => 'required|in:male,female',
                'occupation' => 'required|string|max:255',
                'password' => 'required|string|confirmed|min:8',
                'profile-pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            // dd($validatedData);
        }
        catch (\Illuminate\Validation\ValidationException $e)
        {
            // Handle the validation error
            return back()->withErrors($e->errors())->withInput();
        }
    
        // Handle file upload for profile picture
        $profilePicPath = null;
        if ($request->hasFile('profile-pic')) {
            $profilePicPath = $request->file('profile-pic')->store('profile-pics', 'public');
        }
    
        // Insert the user into the database
        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'birthday' => $validatedData['birthday'],
                'sex' => $validatedData['sex'],
                'occupation' => $validatedData['occupation'],
                'profile_picture' => $profilePicPath,
            ]);
    
            // Redirect to login page after successful signup
            return redirect()->route('login');
        } catch (Exception $e) {
            // Log the error message
            \Log::error('Signup error: ' . $e->getMessage());
    
            // Return back with an error message
            return back()->withErrors(['error' => 'There was a problem creating your account. Please try again.']);
        }
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([ 
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $validatedData['email'];
        $password = $validatedData['password'];

        $user = User::where('email', $email)->first();
        
        // Use Hash::check for password verification
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);

            // Optionally, store user ID in session or directly pass it to the view
            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'birthday' => $user->birthday,
                'sex' => $user->sex,
                'occupation' => $user->occupation,
                'profile_picture' => $user->profile_picture,  // Fixed to use correct property
            ];

            session($data);

            // return view('home', $data);
            return redirect()->route('home');
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function login_page()
    {
        return view('login');
    }

    public function signup_page()
    {
        return view('signup');
    }

    public function front_page()
    {
        return view('frontpage');
    }

    public function home_page()
    {
        return view('home');
    }

    public function message_page()
    {
        return view('message');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logs the user out

        // Optionally, invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function follow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        try {
            $follower_id = session('id');
            $following_id = $request->user_id;

            // Check if already following
            $existingFollow = Follow::where('follower_id', $follower_id)
                                   ->where('following_id', $following_id)
                                   ->first();

            if ($existingFollow) {
                // Unfollow
                $existingFollow->delete();
                $isFollowing = false;
            } else {
                // Follow
                Follow::create([
                    'follower_id' => $follower_id,
                    'following_id' => $following_id
                ]);
                $isFollowing = true;
            }

            return response()->json([
                'success' => true,
                'isFollowing' => $isFollowing,
                'message' => $isFollowing ? 'Successfully followed user' : 'Successfully unfollowed user'
            ]);

        } catch (\Exception $e) {
            Log::error('Follow error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error following user: ' . $e->getMessage()
            ], 500);
        }
    }
}
