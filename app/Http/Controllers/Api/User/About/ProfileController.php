<?php

namespace App\Http\Controllers\Api\User\About;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\About\ProfileRequest;
use App\Services\User\About\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(public ProfileService $profileService)
    {}

    public function findById($id)
    {
        return $this->success($this->profileService->findById($id), "User profile retrieved successfully");
    }

    public function findByUserId()
    {
        return $this->success($this->profileService->findByUserId(), "User profile retrieved successfully");
    }

    public function createOrUpdateProfile(ProfileRequest $request)
    {
        return $this->success($this->profileService->createOrUpdateProfile($request->validated()), "User profile updated successfully");
    }
}
