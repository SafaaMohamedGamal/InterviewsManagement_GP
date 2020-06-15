<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function update(ResetPasswordRequest $request){
        $user = User::find($request->user);
        if(!$user){
            return response()->json([
                'error' => "this user doesn't exist"
            ]);
        }
        
        $user_passwords = $request->only(['current_password', 'password', 'password_confirmation']);
        if (! $user || ! Hash::check($user_passwords['current_password'], $user['password'])) {
            throw ValidationException::withMessages([
                'current_password' => ['current password is incorrect'],
            ]);
        }

        $user->update([
            'password'=>Hash::make($user_passwords['password']),
        ]);

        return response()->json([
            'success' => "updated successfuly"
        ]);
        
    }
}
