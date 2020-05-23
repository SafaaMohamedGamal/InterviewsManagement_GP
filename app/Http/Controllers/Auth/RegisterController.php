<?php

namespace App\Http\Controllers\Auth;

use App\Seeker;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Seeker as SeekerResource;
class RegisterController extends Controller
{
    public function register(StoreUserRequest $request){
        $user = $request->only(['name', 'email', 'password']);
        $user = \App\Helpers\UserAction::store($user);
        $seeker = Seeker::create();
        $seeker->user()->save($user);

        return new SeekerResource($user);
    }
}
