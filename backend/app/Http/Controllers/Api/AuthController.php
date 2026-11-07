<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function profile(Request $request): JsonResponse
    {
        return response()->json(['user' => $request->user()]);
    }

    public function logout(Request $request): JsonResponse
    {
        // hapus token yang sedang dipakai
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
