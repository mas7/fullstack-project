<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use ErrorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): array
    {
        try {
            $user = User::create([
                'name'     => data_get($data, 'name'),
                'email'    => data_get($data, 'email'),
                'password' => bcrypt(data_get($data, 'password')),
            ]);

            $user['token'] = $user->createToken('api-token')->plainTextToken;

            return [
                'message' => 'User registered successfully',
                'data'    => $user,
            ];
        } catch (\Throwable $th) {
            Log::error($th);
            throw new ErrorException('Something went wrong while processing your request. Please contact support.');
        }
    }

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        /** @var User $user */
        $user          = Auth::user();
        $user['token'] = $user->createToken('api-token')->plainTextToken;

        return [
            'message' => 'Login successful',
            'data'    => UserResource::make($user),
        ];
    }
}
