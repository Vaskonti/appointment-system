<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function __construct(private readonly UserServiceInterface $userService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->registerUser(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password')
        );
        if (!isset($user)) {
            return response()->json(['message' => 'User registration failed'], 500);
        }
        return response()->json([
            'message' => 'User registered successfully',
            'token' => $user->createToken('Laravel Passport Grant Client')->accessToken,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!$this->userService->checkUserExists($request->input('email'))) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user = $this->userService->getUserByEmail($request->input('email'));
        if (!$this->userService->validatePassword($user->email, $request->input('password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $user->createToken('Laravel Passport Grant Client')->accessToken,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        if ($user) {
            $token = $request->user()->token();
            $token->revoke();
            return response()->json(['message' => 'User logged out successfully']);
        }
        return response()->json(['message' => 'User not authenticated'], 401);
    }
}
