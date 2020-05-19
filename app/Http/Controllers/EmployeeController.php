<?php

namespace App\Http\Controllers;
use App\Http\Resources\Employee as EmployeeResource;

use App\Employee;
use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index()
    {
        $user = User::all()
          ->where('userable_type', 'App\Employee');
        return EmployeeResource::collection($user);
    }


    public function store(Request $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $userEmployee = User::create($user);
        $Employee = Employee::create();

        $Employee->user()->save($userEmployee);
        return new EmployeeResource($userEmployee);
    }


    public function show($employee)
    {
        $user = User::find($employee);
        return new EmployeeResource($user);
    }

    public function update(Request $request, $employee)
    {
        $employeeinputs = $request->only([
          'position',
          'branch'
        ]);
        $user = User::find($employee);

        $employee = $user->userable;
        $status = $employee->update(
        [
          'position' => $employeeinputs['position'],
          'branch' => $employeeinputs['branch']
        ]);
        return new EmployeeResource($user);
    }


    public function destroy($employee)
    {
      $user = User::find($employee);
      $employee = $user->userable;
      $employee->user()->delete();
      $employee->delete();
      return ['data' => true];
    }
}
