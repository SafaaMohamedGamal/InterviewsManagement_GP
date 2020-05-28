<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    private $userRebo;
    public function __construct(UserRepositoryInterface $userRebository)
    {
        $this->userRebo = $userRebository;
    }

    public function index()
    {
        return UserResource::collection($this->userRebo->getAll());
    }


    public function store(StoreUserRequest $request)
    {
        return new UserResource($this->userRebo->store($request->only(['name', 'email', 'password'])));
    }


    public function show(Request $request, $id)
    {
        return new UserResource($this->userRebo->get($id));
    }


    public function update(UpdateUserRequest $request, $id)
    {
        return new UserResource($this->userRebo->update($id, $request->only(['name', 'email'])));
    }


    public function destroy($id)
    {
        $user = User::destroy($id);
        if ($user) {
            return response()->json(["data" => "deleted successfuly"]);
        }
        return response()->json(["data" => "user doesn't exist"]);
    }
}
