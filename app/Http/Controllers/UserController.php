<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }


    public function store(StoreUserRequest $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $user = \App\Helpers\UserAction::store($user);

        return new UserResource($user);
    }


    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return new UserResource($user);
    }


    public function update(UpdateUserRequest $request, $id)
    {
        $req = $request->only(['name', 'email']);
        $user = \App\Helpers\UserAction::update($id, $req);

        return new UserResource($user);
    }


    public function destroy($id)
    {
        $user = User::destroy($id);
        if ($user) {
            return response()->json([
                "data" => "deleted successfuly",
            ]);
        }
        return response()->json([
            "data" => "user doesn't exist",
        ]);
    }

    public function loggedInUser()
    {
        return new UserResource(current_user());
    }

    public function logoutUser()
    {
        return current_user()->tokens()->delete();
    }
}
