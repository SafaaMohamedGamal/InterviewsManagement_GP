<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }


    public function store(StoreUserRequest $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $user = \App\Helpers\UserAction::store($user);

        return response()->json([
            "data" => $user,
            "status" => 200
        ]);
    }


    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json([
            "data" => $user,
            "status" => 200
        ]);
    }


    public function update(UpdateUserRequest $request, $id)
    {
        $req = $request->only(['name', 'email', 'password']);
        $user = \App\Helpers\UserAction::update($id, $req);

        return response()->json([
            "data" => $user,
            "status" => 200
        ]);
    }


    public function destroy($id)
    {
        $user = User::destroy($id);
        return response()->json([
            "data" => $user,
            "status" => 200
        ]);
    }
}
