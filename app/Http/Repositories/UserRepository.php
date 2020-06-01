<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function getAll()
    {
        return User::all();
    }

    public function get($user)
    {
        return User::find($user);
    }

    public function update($id, $req)
    {
        $user = User::find($id);
        $user->update([
            "name" => isset($req["name"]) ? $req["name"] : $user['name'],
            "email" => isset($req["email"]) ? $req["email"] : $user['email'],
            "password" => isset($req["password"]) ? $req["password"] : $user['password'],
        ]);
        return $user;
    }

    public function store($user)
    {
        $user["password"] = Hash::make($user["password"]);
        return User::create($user);
    }
}
