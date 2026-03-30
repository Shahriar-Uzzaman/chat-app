<?php

namespace App\Repositories\Contracts\User\About;

interface ProfileRepositoryInterface
{
    public function findById($id);
    public function findByUserId($userId);
    public function create($data);
    public function update($userId, $data);
}
