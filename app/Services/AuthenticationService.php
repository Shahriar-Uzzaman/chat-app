<?php

namespace App\Services;

use App\Jobs\SendForgotPasswordOTPEmail;
use App\Jobs\SendVerificationEmail;
use App\Repositories\Contracts\AuthenticationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

            if (!Hash::check($data['password'], $isUserExist->password)) {
                throw new \Exception('Invalid credentials. Email or password is incorrect');
            }

            if (!$isUserExist->email_verified_at) {
                throw new \Exception('Please verify your email before logging in');
            }

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

    public function forgotPassword(array $data)
    {
        DB::beginTransaction();
        try {
            $isUserExist = $this->findByEmail($data['email']);
            if (!$isUserExist) {
                throw new \Exception('User not found');
            }

            if (!empty($isUserExist)){
                $otpCode = $this->otpService->generateOtp([
                    'user_id' => $isUserExist->id,
                    'type' => 1
                ]);
                SendForgotPasswordOTPEmail::dispatch($otpCode, $isUserExist->email, $isUserExist->name);
            }

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function resetPassword(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->findByEmail($data['email']);
            if (!$user) {
                throw new \Exception('User not found');
            }

            $isValidOtp = $this->otpService->validateOtp($user->id, $data['otp_code'], 1);
            if (!$isValidOtp) {
                throw new \Exception('Invalid or Expired OTP code');
            }

            $updatePassword = $this->authRepo->updatePassword($user->id, Hash::make($data['new_password']));
            if (!$updatePassword) {
                throw new \Exception('Failed to update password. Please try again');
            }

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function logout($request)
    {
        try {
            $request->user()->token()->revoke();
            return true;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}