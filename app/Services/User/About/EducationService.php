<?php

namespace App\Services\User\About;

use App\Repositories\Contracts\User\About\EducationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EducationService
{
    public function __construct(public EducationRepositoryInterface $educationRepo)
    {}

    public function findById(int $id)
    {
        try {
            $userEducation = $this->educationRepo->findById($id);
            if (!$userEducation) {
                throw new \Exception("User's education not found!");
            }

            return $userEducation;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function findByUserId()
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                throw new \Exception("Unauthenticated!");
            }

            $userEducation = $this->educationRepo->findByUserId($userId);
            if (!$userEducation) {
                throw new \Exception("User's education not found!");
            }

            return $userEducation;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createOrUpdate(array $data)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::id();
            if (!$userId) {
                throw new \Exception("Unauthenticated!");
            }

            $userEducation = $this->educationRepo->findByUserId($userId);
            if ($userEducation) {
                $userEducation = $this->educationRepo->update($userId, $data);
            } else {
                $data['user_id'] = $userId;
                $userEducation = $this->educationRepo->create($data);
            }

            DB::commit();
            return $userEducation;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
