<?php

namespace App\Http\Controllers;

use App\Seeker;
use App\User;
use Illuminate\Http\Request;

class SeekerController extends Controller
{

    public function index()
    {
      $userSeeker = Seeker::all();
        return [
          "user" => $userSeeker[0],
          "details" => $userSeeker[0]->user
        ];
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
        return [
          "user" => $userSeeker,
          "seeker" => $seeker
        ];
    }

    public function show($seeker)
    {
        $user = User::find($seeker);
        return [
          "seeker" => $user,
          "user" => $user->userable
        ];
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
          ]
          );
        return [
          "user" => $user
        ];
    }

    public function destroy($seeker)
    {
      $user = User::find($seeker);
      $seeker = $user->userable;
      $seeker->user()->delete();
      return true;
    }
}
