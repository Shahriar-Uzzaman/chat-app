<?php

namespace App\Repositories\Eloquent\User\About;

use App\Models\UserProfile;
use App\Repositories\Contracts\User\About\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function findById($id)
    {
        return UserProfile::where('user_id', $id)->first();
    }

    public function findByUserId($userId)
    {
        return UserProfile::where('user_id', $userId)->first();
    }

    public function create($data)
    {
        return UserProfile::create($data);
    }

    public function update($userId, $data)
    {
        return UserProfile::where('user_id', $userId)->update($data);
    }
}
