<?php

namespace App\Http\Controllers;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;

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

    public function store(StoreUserRequest $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $userEmployee = \App\Helpers\UserAction::store($user);
        $Employee = Employee::create();
        $Employee->user()->save($userEmployee);
        return new EmployeeResource($userEmployee);
    }


    public function show(User $employee)
    {
        return new EmployeeResource($employee);
    }

    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        $employeeinputs = $request->only([
          'position',
          'branch'
        ]);
        $userEmployee = $employee->userable;
        $status = $userEmployee->update(
        [
          'position' => $employeeinputs['position'],
          'branch' => $employeeinputs['branch']
        ]);
        return new EmployeeResource($employee);
    }


    public function destroy(User $employee)
    {
      $userEmployee = $employee->userable;
      $userEmployee->user()->delete();
      $userEmployee->delete();
      return ['data' => true];
    }
}
