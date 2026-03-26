<?php

namespace App\Services;

use App\Jobs\SendVerificationEmail;
use App\Repositories\Contracts\AuthenticationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AuthenticationService
{
    public function __construct(public AuthenticationRepositoryInterface $authRepo, public OtpService $otpService)
    {}

    public function findByEmail(string $email): mixed
    {
        try {
            return $this->authRepo->findByEmail($email);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function register(array $data)
    {
        DB::beginTransaction();
        try {
            $isEmailExist = $this->findByEmail($data['email']);
            if ($isEmailExist) {
                throw new \Exception('Email already exists');
            }

            $user = $this->authRepo->store($data);
            if (!empty($user)){
                $otpCode = $this->otpService->generateOtp([
                    'user_id' => $user->id,
                    'type' => 2
                ]);
                SendVerificationEmail::dispatch($otpCode, $data['email'], $data['name']);
            }

            DB::commit();
            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function login(array $data)
    {
        try {
            $isUserExist = $this->findByEmail($data['email']);
            if (!$isUserExist) {
                throw new \Exception('Invalid credentials. Email or password is incorrect');
            }

            // if (!password_verify($data['password'], $isUserExist->password)) {
            //     throw new \Exception('Invalid credentials. Email or password is incorrect');
            // }

            $token = $isUserExist->createToken('auth_token')->accessToken;
            return [
                'user' => $isUserExist,
                'token' => $token
            ];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function verifyEmail(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->findByEmail($data['email']);
            if (!$user) {
                throw new \Exception('User not found');
            }

            $isValidOtp = $this->otpService->validateOtp($user->id, $data['otp_code'], 2);
            if (!$isValidOtp) {
                throw new \Exception('Invalid or Expired OTP code');
            }

            $this->authRepo->markedEmailAsVerified($user->id);
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}