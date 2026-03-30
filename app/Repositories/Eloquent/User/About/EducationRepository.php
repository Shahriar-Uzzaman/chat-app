<?php

namespace App\Repositories\Eloquent\User\About;

use App\Models\UserEducation;
use App\Repositories\Contracts\User\About\EducationRepositoryInterface;

class EducationRepository implements EducationRepositoryInterface
{
    public function findById($id)
    {
        return UserEducation::where('user_id', $id)->first();
    }

    public function findByUserId($userId)
    {
        return UserEducation::where('user_id', $userId)->first();
    }

    public function create($data)
    {
        return UserEducation::create($data);
    }

    public function update($userId, $data)
    {
        return UserEducation::where('user_id', $userId)->update($data);
    }
}
