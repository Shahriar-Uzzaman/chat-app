<?php

use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\User\About\ProfileController;
use App\Http\Controllers\Api\User\About\EducationController;
use App\Http\Controllers\Api\Location\CountryController;
use App\Http\Controllers\Api\Location\StateController;

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

        Route::prefix("locations")->group(function () {
            Route::prefix("/countries")->group(function () {
                Route::get("/", [CountryController::class, 'getAll']);
                Route::get("/{id}", [CountryController::class, "getById"])->whereNumber('id');
                Route::post('/', [CountryController::class, 'store']);
                Route::put('/{id}', [CountryController::class, 'update']);
                Route::delete('/{id}', [CountryController::class, 'delete']);
            });

            Route::prefix("/states")->group(function () {
                Route::get("/", [StateController::class, 'getAll']);
                Route::get("/{id}", [StateController::class, "getById"])->whereNumber('id');
                Route::get("/country/{id}", [StateController::class, "getByCountryId"])->whereNumber('id');
                Route::post('/', [StateController::class, 'create']);
                Route::put('/{id}', [StateController::class, 'update']);
                Route::delete('/{id}', [StateController::class, 'delete']);
            });
        });
    });
});
