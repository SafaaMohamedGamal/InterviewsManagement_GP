<?php

namespace App\Http\Controllers;
use App\User;
use App\Seeker;
use Illuminate\Http\Request;
use App\Http\Requests\Seeker\StoreSeekerRequest;
use App\Http\Resources\Seeker as SeekerResource;
use App\Http\Requests\Seeker\UpdateSeekerRequest;

class SeekerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $this->authorize('viewAny');
        $userSeeker = User::all()
          ->where('userable_type', 'App\Seeker');
        return SeekerResource::collection($userSeeker);
    }

    public function store(StoreSeekerRequest $request)
    {
        $this->authorize('create');
        $user = $request->only(['name', 'email', 'password']);
        $userSeeker = \App\Helpers\UserAction::store($user);
        $seeker = Seeker::create();
        $seeker->user()->save($userSeeker);
        $userSeeker->assignRole('seeker');
        return new SeekerResource($userSeeker);
    }

    public function show(User $seeker)
    {
        $this->authorize('view', $seeker->userable_type === 'App\Seeker'? $seeker->userable : null);
        return new SeekerResource($seeker);
    }

    public function update(UpdateSeekerRequest $request, User $seeker)
    {
        $this->authorize('update', $seeker->userable_type === 'App\Seeker'? $seeker->userable : null);
        $inputs = $request->only([
          'address',
          'city',
          'seniority',
          'expYears',
          'currentJob',
          'currentSalary',
          'expectedSalary',
          'cv',
          'phone'
        ]);
        // return $inputs;
        $status = \App\Helpers\SeekerAction::update($inputs, $seeker);
        return new SeekerResource($seeker);
    }

    public function destroy(User $seeker)
    {
        $this->authorize('delete', $seeker->userable_type === 'App\Seeker'? $seeker->userable : null);
        $userSeeker = $seeker->userable;
        $userSeeker->user()->delete();
        $userSeeker->delete();
        return ['data' => true];
    }
}
