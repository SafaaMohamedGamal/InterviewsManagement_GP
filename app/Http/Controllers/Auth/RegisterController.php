<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;

class RegisterController extends Controller
{
    // to be modified
    public function register(Request $request){
        $user = $request->only(['name', 'email', 'password']);
        $user["password"] = Hash::make($user["password"]);
        User::create($user);
        return response()->json([
            "data" => $user,
            ]);
    }
}
