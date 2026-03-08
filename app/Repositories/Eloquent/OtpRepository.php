<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\OtpRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OtpRepository implements OtpRepositoryInterface
{
    public function findLatestByUserId(int $userId, int $type)
    {
        return DB::table('otps')->where('user_id', $userId)
            ->where('type', $type)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function createOrUpdateOtp(array $data){
        return DB::table('otps')->updateOrInsert($data);
    }

    public function findValidOtp(int $userId, int $code, string $type)
    {
        return DB::table('otps')->where('user_id', $userId)->where('type', $type)->where('code', $code)->where('is_used', false)->where('expires_at', '>', now())->first();
    }

    public function markAsUsed(int $otpId)
    {
        return DB::table('otps')->where('id', $otpId)->update(['is_used' => true]);
    }

    public function incrementAttempts(int $otpId)
    {
        return DB::table('otps')->where('id', $otpId)->increment('attempts');
    }
}
