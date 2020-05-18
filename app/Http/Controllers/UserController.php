<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $user["password"] = Hash::make($user["password"]);
        User::create($user);
        return response()->json([
            "data" => $user,
            "status" => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json([
            "data" => $user,
            "status" => 200
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $req = $request->only(['name', 'email', 'password']);
        $user = User::find($id);
        $user->update([
            "name" => isset($req["name"]) ? $req["name"] : $user['name'],
            "email" => isset($req["email"]) ? $req["email"] : $user['email'],
            "password" => isset($req["password"]) ? Hash::make($req["password"]) : $user['password'],
        ]);
        return response()->json([
            "data" => $user,
            "status" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);
        return response()->json([
            "data" => $user,
            "status" => 200
        ]);
    }
}
