<?php

namespace App\Services;

use App\Models\User;
use ErrorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user.
     *
     * @param  array  $data
     * @return \App\Models\User
     * @throws \ErrorException
     */
    public function register(array $data): User
    {
        try {
            $user = User::create([
                'name'     => data_get($data, 'name'),
                'email'    => data_get($data, 'email'),
                'password' => bcrypt(data_get($data, 'password')),
            ]);

            $user['token'] = $user->createToken('api-token')->plainTextToken;

            return $user;
        } catch (\Throwable $th) {
            Log::error($th);
            throw new ErrorException('Something went wrong while processing your request. Please contact support.');
        }
    }

    /**
     * Authenticate a user.
     *
     * @param  array  $credentials
     * @return \App\Models\User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(array $credentials): User
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        /** @var User $user */
        $user          = Auth::user();
        $user['token'] = $user->createToken('api-token')->plainTextToken;

        return $user;
    }
}
