<?php

namespace App\Repositories\Contracts;

interface OtpRepositoryInterface
{
    public function findLatestByUserId(int $userId, int $type);
    public function createOrUpdateOtp(array $data);
    public function findValidOtp(int $userId, int $code, string $type);
    public function markAsUsed(int $otpId);
    public function incrementAttempts(int $otpId);
}
