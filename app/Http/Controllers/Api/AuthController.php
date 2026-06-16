<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'nim' => 'required',
        'password' => 'required',
        'role' => 'required|in:admin,mahasiswa',
    ]);

    if (!Auth::attempt([
        'nim' => $request->nim,
        'password' => $request->password,
    ])) {
        return response()->json([
            'success' => false,
            'message' => 'NIM atau password salah'
        ], 401);
    }

    $user = User::where(
        'nim',
        $request->nim
    )->first();

    if ($user->role !== $request->role) {
        return response()->json([
            'success' => false,
            'message' => 'Role tidak sesuai'
        ], 401);
    }

    $token = $user
        ->createToken('flutter-token')
        ->plainTextToken;

    return response()->json([
        'success' => true,
        'token' => $token,
        'user' => $user
    ]);
}

    public function register(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'nim' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,mahasiswa',
        ]);

        $user = User::create([
        'name' => $request->name,
        'nim' => $request->nim,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        ]);

        $token = $user->createToken('flutter-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil',
            'token' => $token,
            'user' => $user,
        ], 201);
    }
}