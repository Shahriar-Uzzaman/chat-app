<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\AuthenticationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AuthenticationRepository implements AuthenticationRepositoryInterface
{
    public function findByEmail(string $email)
    {
        return DB::table('users')->where('email', $email)->first();
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function markedEmailAsVerified(int $userId)
    {
        return DB::table('users')->where('id', $userId)->update(['email_verified_at' => now()]);
    }
}