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
        $seeker = new Seeker;
        $seeker->phone=$request['phone'];
        $seeker->save();
        $user = \App\Helpers\UserAction::store($user);
        $seeker->user()->save($user);
        $user->assignRole('seeker');

        return new SeekerResource($user);
    }
}
