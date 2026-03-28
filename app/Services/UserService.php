<?php

namespace App\Services;

use App\Jobs\SendVerificationEmail;
use App\Repositories\Contracts\UserRepositoryInterface;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function changePassword(array $data)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::user()->id;
            if (!$userId) {
                throw new \Exception("Unauthorized action.");
            }

            $user = $this->userRepo->findUserById($userId);
            if (!$user) {
                throw new \Exception("User not found.");
            }

            if (!password_verify($data['current_password'], $user->password)) {
                throw new \Exception("Current password is incorrect.");
            }

            $updatePassword = $this->userRepo->updateUser($userId, [
                'password' => Hash::make($data['new_password'])
            ]);
            if (!$updatePassword) {
                throw new \Exception("Failed to update password.");
            }

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
