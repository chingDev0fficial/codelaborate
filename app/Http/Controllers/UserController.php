<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
}
