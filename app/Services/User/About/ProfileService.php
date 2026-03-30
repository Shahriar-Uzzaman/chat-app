<?php

namespace App\Services\User\About;

use App\Repositories\Contracts\User\About\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class ProfileService
{
    public function __construct(public ProfileRepositoryInterface $profileRepo)
    {}

    public function findById(int $id){
        try {
            $userProfile = $this->profileRepo->findById($id);
            if (!$userProfile) {
                throw new \Exception('Profile not found');
            }

            return $userProfile;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function findByUserId()
    {
        try {
            $userId = Auth::id();
            $userProfile = $this->profileRepo->findByUserId($userId);
            if (!$userProfile) {
                throw new \Exception('Profile not found');
            }

            return $userProfile;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createOrUpdateProfile(array $data)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $userProfile = $this->profileRepo->findByUserId($userId);
            if (!$userProfile) {
                $data['user_id'] = $userId;
                $userProfile = $this->profileRepo->create($data);
            } else {
                $userProfile = $this->profileRepo->update($userId, $data);
            }

            DB::commit();
            return $userProfile;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
