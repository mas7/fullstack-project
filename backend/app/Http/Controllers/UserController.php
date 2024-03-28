<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailsJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Send emails to all users asynchronously.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmails(): JsonResponse
    {
        User::each(fn ($user) => SendEmailsJob::dispatch($user));

        return response()->json(['message' => 'Email sent successfully']);
    }
}
