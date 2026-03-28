<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(public UserService $userService)
    {}

    public function getAllUsers()
    {
        return $this->success($this->userService->getAllUsers(), "Users retrieved successfully.");
    }

    public function getUserById($id)
    {
        return $this->success($this->userService->getUserById($id), "User retrieved successfully.");
    }

    public function updateUser($id, UpdateRequest $request)
    {
        return $this->success($this->userService->updateUser($id, $request->validated()), "User updated successfully.");
    }

    public function deleteUser($id)
    {
        return $this->success($this->userService->deleteUser($id), "User deleted successfully.");
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->success($this->userService->changePassword($request->validated()), "Password changed successfully.");
    }
}
