<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
       Route::get('/', [UserController::class, 'getAllUsers']);
       Route::get('/{id}', [UserController::class, 'getUserById']);
       Route::post('/', [UserController::class, 'createUser']);
       Route::put('/{id}', [UserController::class, 'updateUser']);
       Route::delete('/{id}', [UserController::class, 'deleteUser']);
    });
});
