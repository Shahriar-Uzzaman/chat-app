<?php

namespace App\Repositories\Contracts;

interface AuthenticationRepositoryInterface
{
    public function findByEmail(string $email);
    public function store(array $data);
    public function markedEmailAsVerified(int $userId);
    public function updatePassword(int $userId, string $newPassword);
}