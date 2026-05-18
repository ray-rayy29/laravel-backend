<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'message' => 'Registrasi berhasil!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registrasi gagal!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // LOGIN
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (!Auth::attempt($validated)) {
                return response()->json([
                    'message' => 'Email atau password salah!'
                ], 401);
            }

            $user = Auth::user();
            
            return response()->json([
                'message' => 'Login berhasil!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login gagal!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'message' => 'Logout berhasil!'
        ], 200);
    }

    // GET USER
    public function user(Request $request)
    {
        return response()->json([
            'user' => Auth::user()
        ]);
    }
}