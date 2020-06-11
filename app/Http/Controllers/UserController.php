<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;

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

    public function loggedInUser()
    {
        return new UserResource(current_user());
    }

    public function logoutUser()
    {
        return current_user()->tokens()->delete();
    }

    public function uploadPhoto(Request $request)
    {
        $request->only(['photo']);
        $photo = $request['photo'];
        // $this->userRebo->uploadPhoto($photo);
        $photoName=time().'.'.$photo->getClientOriginalExtension();
        $photo->storeAs('public/images/profiles', $photoName);
        $user = current_user();
        if ($user->image) {
            Storage::delete('public/images/profiles/'.$user->image);
        }
        $user->image = $photoName ;
        $user->save();

        return response()->json('uploaded sucessful');
    }

    public function renderPhoto($photo)
    {
        // $file = Storage::get('public/images/profiles/'.$photo);
        $storagePath = storage_path('app/public/images/profiles/'.$photo);
        return response()->file($storagePath, ['Content-Type' => 'image/jpeg']);
    }
}
