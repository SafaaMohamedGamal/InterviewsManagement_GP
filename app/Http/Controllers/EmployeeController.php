<?php

namespace App\Http\Controllers;

use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;

use App\Employee;
use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  private $userRebo;
  public function __construct(UserRepositoryInterface $userRebository)
  {
    $this->userRebo = $userRebository;
  }

  public function index()
  {
    $this->authorize('viewAny');
    $user = Employee::all();
    // ->where('userable_type', 'App\Employee');
    return EmployeeResource::collection($user);
  }

  public function store(StoreUserRequest $request)
  {
    $this->authorize('create');
    $user = $request->only(['name', 'email', 'password', 'position', 'branch']);
    $userEmployee = $this->userRebo->store($user);
    $Employee = Employee::create($user);
    $Employee->user()->save($userEmployee);
    $userEmployee->assignRole('employee');
    return new EmployeeResource($Employee);
  }


  public function show(User $employee)
  {
    $this->authorize('view', $employee->userable_type === 'App\Employee' ? $employee->userable : null);
    return new EmployeeResource($employee->userable);
  }

  public function update(UpdateEmployeeRequest $request, User $employee)
  {
    $this->authorize('edit', $employee->userable_type === 'App\Employee' ? $employee->userable : null);
    $employeeinputs = $request->only([
      'name',
      'email',
      'position',
      'branch'
    ]);
    $userEmployee = $this->userRebo->update($employee->id, $employeeinputs);
    $status = \App\Helpers\EmployeeAction::update($employeeinputs, $employee);
    return new EmployeeResource($employee->userable);
  }


  public function destroy(User $employee)
  {
    $this->authorize('delete', $employee->userable_type === 'App\Employee' ? $employee->userable : null);
    $userEmployee = $employee->userable;
    $userEmployee->user()->delete();
    $userEmployee->delete();
    return ['data' => true];
  }
}
