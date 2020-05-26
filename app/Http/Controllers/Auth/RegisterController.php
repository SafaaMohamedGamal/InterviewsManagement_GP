<?php

namespace App\Http\Controllers\Auth;

use App\Seeker;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seeker\StoreSeekerRequest;
use App\Http\Resources\Seeker as SeekerResource;

class RegisterController extends Controller
{
    public function register(StoreSeekerRequest $request){
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
