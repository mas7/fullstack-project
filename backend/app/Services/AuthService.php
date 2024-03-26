<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

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

            return [
                'message' => 'User registered successfully',
                'data'    => $user,
                'code'    => 200,
            ];
        } catch (\Throwable $th) {
            Log::error($th);

            return [
                'message' => 'Something went wrong while processing your request. Please contact support.',
                'data'    => null,
                'code'    => 400,
            ];
        }
    }
}
