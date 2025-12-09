<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    // GET /admin/users
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => User::select('id', 'fullname', 'email', 'phone', 'year_level', 'faculty', 'role')->get()
        ]);
    }

    // GET /admin/users/{id}
    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data' => User::findOrFail($id)
        ]);
    }

    // POST /admin/users
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'year_level' => 'nullable|string',
            'faculty'  => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
            'role'     => 'required|string|in:user,admin'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    // PUT /admin/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'phone'    => 'nullable|string|max:20',
            'year_level' => 'nullable|integer',
            'faculty'  => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'role'     => 'required|string|in:user,admin'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    // DELETE /admin/users/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // prevent delete admin itself (optional safety)
        if ($user->role === 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Cannot delete admin accounts.'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
