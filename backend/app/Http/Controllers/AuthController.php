<?php

namespace App\Http\Controllers;

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

        return response()->json($response, data_get($response, 'code', 200));
    }
}