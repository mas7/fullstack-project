<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('generate-sso-link', [AuthController::class, 'generateSSOLink']);
Route::get('single-sign-on/{user}', [AuthController::class, 'singleSignOn'])->name('single-sign-on')->middleware('signed');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('projects', ProjectController::class);

    Route::post('users/send-emails', [UserController::class, 'sendEmails']);
});
