<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        // 
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $response = $this->authService->register($data);

        return response()->json($response);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $response = $this->authService->login($data);

        return response()->json($response);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
