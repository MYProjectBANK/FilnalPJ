<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'year_level' => $request->year_level,
            'faculty' => $request->faculty,
            'role' => 'user',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register success',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid login information'],
            ]);
        }

        // create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'token' => $token,
            'user' => $user
        ]);
    }

    // GET USER DATA
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    // Update Profile
public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'fullname' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,'.$user->id,
        'phone' => 'sometimes|string|max:20',
        'year_level' => 'sometimes|integer',
        'faculty' => 'sometimes|string|max:100',
    ]);

    $user->update($request->only([
        'fullname',
        'email',
        'phone',
        'year_level',
        'faculty',
    ]));

    return response()->json([
        'message' => 'Profile updated successfully',
        'user' => $user,
    ]);
}

}
