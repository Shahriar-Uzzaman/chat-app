<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function findAllUsers();
    public function findUserById($id);
    public function findUserByEmail($email);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
}