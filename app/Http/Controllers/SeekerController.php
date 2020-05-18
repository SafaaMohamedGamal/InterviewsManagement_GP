<?php

namespace App\Http\Controllers;
use App\Http\Resources\Seeker as SeekerResource;

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

    public function store(Request $request)
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
        $user = $request->only(['name', 'email', 'password']);
        $userSeeker = User::create($user);
        $seeker = Seeker::create();
        $seeker->user()->save($userSeeker);

        return new SeekerResource($userSeeker);
    }

    public function show($seeker)
    {
        $user = User::find($seeker);
        return new SeekerResource($user);
    }

    public function update(Request $request, $seeker)
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
        $user = User::find($seeker);

        $seeker = $user->userable;
        $seeker = $seeker->update(
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

        return new SeekerResource($user);
    }

    public function destroy($seeker)
    {
        $user = User::find($seeker);
        $seeker = $user->userable;
        $seeker->user()->delete();
        $seeker->delete();
        return ['data' => true];
    }
}
