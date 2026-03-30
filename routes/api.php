<?php

use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\User\About\ProfileController;
use App\Http\Controllers\Api\User\About\EducationController;

Route::prefix('v1')->group(function () {
    // Guest/Public routes
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthenticationController::class, 'login']);
        Route::post('/register', [AuthenticationController::class, 'register']);
        Route::post('/verify-email', [AuthenticationController::class, 'verifyEmail']);
        Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
        Route::post('/reset-password', [AuthenticationController::class, 'resetPassword']);
    });

    # Authenticated routes
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/logout', [AuthenticationController::class, 'logout']);
        Route::post('/change-password', [UserController::class, 'changePassword']);

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'getAllUsers']);
            Route::get('/{id}', [UserController::class, 'getUserById']);
            Route::patch('/{id}', [UserController::class, 'updateUser']);
            Route::delete('/{id}', [UserController::class, 'deleteUser']);

            Route::prefix('profiles')->group(function () {
                Route::get('/me', [ProfileController::class, 'findByUserId']);
                Route::get('/{id}', [ProfileController::class, 'findById'])->whereNumber('id');
                Route::post('/', [ProfileController::class, 'createOrUpdateProfile']);

                Route::prefix("educations")->group(function () {
                    Route::get('/me', [EducationController::class, 'findByUserId']);
                    Route::get('/{id}', [EducationController::class, 'findById'])->whereNumber('id');
                    Route::post('/', [EducationController::class, 'createOrUpdateEducation']);
                });
            });
        });
    });
});
