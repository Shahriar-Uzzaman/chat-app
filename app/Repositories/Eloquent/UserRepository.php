<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function findAllUsers()
    {
        return DB::table('users')->get();
    }

    public function findUserById($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }

    public function findUserByEmail($email)
    {
        return DB::table('users')->where('email', $email)->first();
    }

    public function createUser(array $data)
    {
//        return DB::table("users")->insert($data);
        $id = DB::table("users")->insertGetId($data);
        return $this->findUserById($id);
    }

    public function updateUser($id, array $data)
    {
        return DB::table("users")->where('id', $id)->update($data);
    }

    public function deleteUser($id)
    {
        return DB::table("users")->where('id', $id)->delete();
    }
}
