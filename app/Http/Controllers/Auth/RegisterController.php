<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Seeker;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;
use App\Http\Resources\Seeker as SeekerResource;

class RegisterController extends Controller
{
    // to be modified
    public function register(StoreUserRequest $request){
        $user = $request->only(['name', 'email', 'password']);
        $user = \App\Helpers\UserAction::store($user);
        $seeker = Seeker::create();
        $seeker->user()->save($user);

        return new SeekerResource($user);
    }
}
