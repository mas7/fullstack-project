<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        // 
    }

    /**
     * Register a new user.
     *
     * @param  RegisterUserRequest  $request
     * @return JsonResponse
     * @throws \ErrorException
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->authService->register($data);

        return response()->json([
            'message' => 'User registered successfully',
            'data'    => UserResource::make($user),
        ]);
    }

    /**
     * Authenticate a user.
     *
     * @param  LoginUserRequest  $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->authService->login($data);

        return response()->json([
            'message' => 'Login successful',
            'data'    => UserResource::make($user),
        ]);
    }

    /**
     * Log out the authenticated user (revoke the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        request()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
