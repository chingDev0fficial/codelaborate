<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        // Validate the form input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'month' => 'required|integer|between:1,12',
            'day' => 'required|integer|between:1,31',
            'sex' => 'required|string|in:male,female',
            'occupation' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
            'profile-pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        dd($validatedData);
    
        // Combine the year, month, and day into a birthdate
        // $birthdate = $validatedData['year'] . '-' . $validatedData['month'] . '-' . $validatedData['day'];
    
        // // Handle file upload for profile picture
        // $profilePicPath = null;
        // if ($request->hasFile('profile-pic')) {
        //     $profilePicPath = $request->file('profile-pic')->store('profile-pics', 'public');
        // }
    
        // // Insert the user into the database
        // try {
        //     User::create([
        //         'name' => $validatedData['name'],
        //         'email' => $validatedData['email'],
        //         'password' => Hash::make($validatedData['password']),
        //         'birthday' => $birthdate,
        //         'sex' => $validatedData['sex'],
        //         'occupation' => $validatedData['occupation'],
        //         'profile_picture' => $profilePicPath,
        //     ]);
    
        //     // Redirect to login page after successful signup
        //     return redirect()->route('login')->with('success', 'Account created successfully. Please log in.');
        // } catch (\Exception $e) {
        //     // Log the error message
        //     \Log::error('Signup error: ' . $e->getMessage());
    
        //     // Return back with an error message
        //     return back()->withErrors(['error' => 'There was a problem creating your account. Please try again.']);
        // }
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
                'name' => $user->name,
                'profile_picture' => $user->profile_pic,  // Fixed to use correct property
            ];

            return view('home', $data);
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

    public function logout(Request $request)
    {
        Auth::logout(); // Logs the user out

        // Optionally, invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
