<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $request->validate([
            "email" => "required|email|max:200|unique:users,email",
            "name" => "required|max:200",
            "password" => "required|max:200"
        ]);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        return response()->json([
            "messages" => "Account Created Successfly",
        ]);
    }
    public function Login(Request $request)
    {
        $request->validate([
            "email" => "required|email|max:200|exists:users,email",
            "password" => "required|max:200"
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth-token");
                return response()->json([
                    "message" => "user exist",
                    "token" => $token->plainTextToken,
                ]);
            } else {
                return response()->json([
                    "message" => "password is wrong"
                ]);
            }
        } else {
            return response()->json([
                "message" => "invalid credentials"
            ]);
        }
    }

    public function profile()
    {
        // return new UserResource(auth()->user());
        return response()->json(auth()->user());
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json("log out successfly");
    }
}
