<?php

namespace App\Helpers;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserAction
{
    public static function update($id, $req)
    {
        $user = User::find($id);
        $user->update([
            "name" => isset($req["name"]) ? $req["name"] : $user['name'],
            "email" => isset($req["email"]) ? $req["email"] : $user['email'],
            "password" => isset($req["password"]) ? Hash::make($req["password"]) : $user['password'],
        ]);
        return $user;
    }
    
    public static function store($user)
    {
        $user["password"] = Hash::make($user["password"]);
        return User::create($user);
    }
}
