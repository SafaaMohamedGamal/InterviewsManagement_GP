<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return \App\Helpers\UserAction::store($user);
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
        return \App\Helpers\UserAction::update($id, $req);
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
