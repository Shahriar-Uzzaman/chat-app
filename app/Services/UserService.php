<?php

namespace App\Services;

use App\Jobs\SendVerificationEmail;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(public UserRepositoryInterface $userRepo)
    {}

    public function getAllUsers()
    {
        try {
            return $this->userRepo->findAllUsers();
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUserById(int $id)
    {
        try {
            if (!$id || !is_numeric($id) || $id <= 0) {
                throw new \Exception("Empty or Invalid user ID provided.");
            }

            $user = $this->userRepo->findUserById($id);
            if (!$user) {
                throw new \Exception("User not found.");
            }

            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function findUserByEmail(string $email)
    {
        try {
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                throw new \Exception("Empty or Invalid email provided.");
            }

            $user = $this->userRepo->findUserByEmail($email);
            if (!$user) {
                throw new \Exception("User not found.");
            }

            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function createUser(array $data)
    {
        DB::beginTransaction();
        try {
            $isEmailExists = $this->userRepo->findUserByEmail($data['email']);
            if ($isEmailExists) {
                throw new \Exception("Email already exists.");
            }

            $data['password'] = bcrypt($data['password']);
            $user = $this->userRepo->createUser($data);
            if (!empty($user)) {
                $generatedOTP = $this->generateOTP(6);
                SendVerificationEmail::dispatch($generatedOTP, $data['email'], $data['name']);
            }
            DB::commit();
            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateUser(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $isUserExists = $this->userRepo->findUserById($id);
            if (!$isUserExists) {
                throw new \Exception("User not found.");
            }

            if (isset($data['email'])) {
                $isEmailExists = $this->userRepo->findUserByEmail($data['email']);
                if ($isEmailExists && $isEmailExists->id !== $id) {
                    throw new \Exception("Email already exists.");
                }
            }

            $user = $this->userRepo->updateUser($id, $data);
            DB::commit();
            return $this->getUserById($id);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteUser(int $id)
    {
        DB::beginTransaction();
        try {
            $isUserExists = $this->userRepo->findUserById($id);
            if (!$isUserExists) {
                throw new \Exception("User not found.");
            }

            $this->userRepo->deleteUser($id);
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function generateOTP(int $length = 6): int
    {
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= random_int(0, 9);
        }
        return (int)$otp;
    }
}
