<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;
use App\Http\Requests\User\StoreUserRequest;

class RegisterController extends Controller
{
    // to be modified
    public function register(StoreUserRequest $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        dd($request);
        $user["password"] = Hash::make($user["password"]);
        User::create($user);
        return response()->json([
            "data" => $user,
            "access_token" => $user->createToken($request->device_name)->plainTextToken
        ]);
    }
}
