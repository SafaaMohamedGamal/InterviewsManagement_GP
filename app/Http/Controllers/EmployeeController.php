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
    public function __construct()
    {
    }

    public function index()
    {
        $this->authorize('viewAny');
        $user = User::all()
          ->where('userable_type', 'App\Employee');
        return EmployeeResource::collection($user);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create');
        $user = $request->only(['name', 'email', 'password']);
        $details = $request->only(['position', 'branch']);
        $userEmployee = \App\Helpers\UserAction::store($user);
        $Employee = Employee::create($details);
        $Employee->user()->save($userEmployee);
        $userEmployee->assignRole('employee');
        return new EmployeeResource($userEmployee);
    }


    public function show(User $employee)
    {
        $this->authorize('view', $employee->userable_type === 'App\Employee'? $employee->userable : null);
        return new EmployeeResource($employee);
    }

    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        $this->authorize('edit', $employee->userable_type === 'App\Employee'? $employee->userable : null);
        $employeeinputs = $request->only([
          'position',
          'branch'
        ]);
        $status = \App\Helpers\EmployeeAction::update($employeeinputs, $employee);
        return new EmployeeResource($employee);
    }


    public function destroy(User $employee)
    {
      $this->authorize('delete', $employee->userable_type === 'App\Employee'? $employee->userable : null);
      $userEmployee = $employee->userable;
      $userEmployee->user()->delete();
      $userEmployee->delete();
      return ['data' => true];
    }
}
