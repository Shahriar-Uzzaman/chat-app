<?php

namespace App\Http\Controllers\Api\User\About;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\About\EducationRequest;
use App\Services\User\About\EducationService;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function __construct(public EducationService $educationService)
    {}

    public function findById($id)
    {
        return $this->success($this->educationService->findById($id), "User's education retrieved successfully!");
    }

    public function findByUserId()
    {
        return $this->success($this->educationService->findByUserId(), "User's education retrieved successfully!");
    }

    public function createOrUpdateEducation(EducationRequest $request)
    {
        return $this->success($this->educationService->createOrUpdate($request->validated()), "User's education updated successfully!");
    }
}
