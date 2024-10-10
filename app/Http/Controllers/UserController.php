<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Controllers\Log;
use Illuminate\Auth\Events\Logout;
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

        echo "<script>console.log('PHP Value: " . $validatedData['name'] . "');</script>";
        
    }


    public function login()
    {
        $validatedData = request()->validate([
            "email"=> "required|email",
            "password"=> "required|string",
        ]);

        $email = $validatedData["email"];
        $password = $validatedData["password"];

        $user = User::where('email', $email)->first();

        if($user && $password == $user->password)
        {
            Auth::login($user);

            global $userID;
            $userID = $user->id;

            $data = [
                "name" => $user->name,
                "profile_picture" => $user->profile_picture
            ];

            return view('home', $data);
        }
        else
        {
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

    public function logout(Request $request)
    {
        Auth::logout(); // Logs the user out

        // Optionally, invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
