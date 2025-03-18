<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $request->validate([
            'usuari' => 'required|unique:users,usuari',
            'nom' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'rol' => 'required|in:client,vendedor',
        ]);

        Log::debug('Request Data:', $request->all());

        $user = new User();
        $user->usuari = $request->usuari;
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->rol = $request->rol;
        $user->img = 'images/users/default.png';

        if($user->save()) {
            return response()->json($user, 200);
        }

        return response()->json(['error' => 'Error creating user'], 500);
    }

    public function login(Request $request)
    {
        // Validate request input
        $request->validate([
            'usuari' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('usuari', $request->usuari)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if($user) {
            return response()->json($user, 200);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    public function getUserByUsername(Request $request)
    {
        $username = $request->query('username');

        if (!$username) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        $user = User::where('usuari', $username)->first();

        if($user) {
            return response()->json($user, 200);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable|same:password',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'direccio' => 'nullable|string',
        ]);

        Log::debug('Request Data:', $request->all());

        $user = User::find(Auth::user()->id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->direccio = $request->direccio;

        if ($request->hasFile('img')) {
            $imagePath = 'images/users/' . Str::random(32) . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(public_path('images/users'), $imagePath);
            $user->img = $imagePath;
        }

        if ($user->save()) {
            return response()->json(['message' => 'User updated successfully', $user], 200);
        }

        return response()->json(['error' => 'Error updating user'], 500);
    }

    /**
     * Update the password of the user.
     */
    public function updatePassword(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json(['error' => 'Email is required'], 400);
        }

        $request->validate([
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->new_password);
        if ($user->save()) {
            return response()->json(['message' => 'Password updated successfully'], 200);
        }

        return response()->json(['error' => 'Error updating password'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $user = User::find(Auth::user()->id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($user->delete()) {
            return response()->json(['message' => 'User deleted successfully'], 200);
        }

        return response()->json(['error' => 'Error deleting user'], 500);
    }
}
