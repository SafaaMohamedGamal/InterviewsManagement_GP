<?php

namespace App\Http\Controllers;
use App\Http\Resources\Seeker as SeekerResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\Seeker\UpdateSeekerRequest;

use App\Seeker;
use App\User;
use Illuminate\Http\Request;

class SeekerController extends Controller
{

    public function index()
    {
        $userSeeker = User::all()
          ->where('userable_type', 'App\Seeker');
        return SeekerResource::collection($userSeeker);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $userSeeker = \App\Helpers\UserAction::store($user);
        $seeker = Seeker::create();
        $seeker->user()->save($userSeeker);
        return new SeekerResource($userSeeker);
    }

    public function show(User $seeker)
    {
        return new SeekerResource($seeker);
    }

    public function update(UpdateSeekerRequest $request, User $seeker)
    {
        $inputs = $request->only([
          'address',
          'city',
          'seniority',
          'expYears',
          'currentJob',
          'currentSalary',
          'expectedSalary',
          'cv'
        ]);
        $userSeeker = $seeker->userable;
        $userSeeker = $userSeeker->update(
          [
          'address' => $inputs['address'],
          'city' => $inputs['city'],
          'seniority' => $inputs['seniority'],
          'expYears' => $inputs['expYears'],
          'currentJob' => $inputs['currentJob'],
          'currentSalary' => $inputs['currentSalary'],
          'expectedSalary' => $inputs['expectedSalary'],
          'cv' => $inputs['cv']
          ]);
        return new SeekerResource($seeker);
    }

    public function destroy(User $seeker)
    {
        $userSeeker = $seeker->userable;
        $userSeeker->user()->delete();
        $userSeeker->delete();
        return ['data' => true];
    }
}
