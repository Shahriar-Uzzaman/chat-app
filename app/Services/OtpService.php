<?php

namespace App\Services;

use App\Repositories\Contracts\OtpRepositoryInterface;
use Hash;

class OtpService
{
    public function __construct(public OtpRepositoryInterface $otpRepo) {}

    public function generateOtp(array $data)
    {
        $userId = $data['user_id'];
        $type = $data['type'];
        $latestOtp = $this->otpRepo->findLatestByUserId($userId, $type);
        if ($latestOtp && now()->parse($latestOtp->created_at)->addMinute()->isFuture()) {
            throw new \Exception('Please wait before requesting a new OTP.');
        }

        $code = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        $otpData = [
            'user_id' => $userId,
            'type' => $type,
            'code' => Hash::make((string)$code),
            'expires_at' => $expiresAt,
            'is_used' => false,
            'attempts' => 0,
        ];

        $this->otpRepo->createOrUpdateOtp($otpData);

        return $code;
    }

    public function validateOtp(int $userId, int $code, int $type)
    {
        $otp = $this->otpRepo->findValidOtp($userId, $code, $type);

        if ($otp) {
            $this->otpRepo->markAsUsed($otp->id);

            return true;
        }

        $latestOtp = $this->otpRepo->findLatestByUserId($userId, $type);
        if ($latestOtp && ! $latestOtp->is_used && now()->parse($latestOtp->expires_at)->isFuture()) {
            $this->otpRepo->incrementAttempts($latestOtp->id);
        }

        if (Hash::check((string)$code, $latestOtp->code)) {
            $this->otpRepo->markAsUsed($latestOtp->id);
            return true;
        }

        return false;
    }
}
