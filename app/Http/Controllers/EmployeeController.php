<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;

use App\Employee;
use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  private $employeeRebo;
  public function __construct(UserRepositoryInterface $employeeRebository)
  {
    $this->employeeRebo = $employeeRebository;
  }

  public function index(Request $request)
  {
    $perPage = $request['perPage'] ? $request['perPage'] : 15;
    $this->authorize('viewAny');
    $user = Employee::simplePaginate($perPage);
    return EmployeeResource::collection($user);
  }

  public function store(StoreUserRequest $request)
  {
    $this->authorize('create');
    $employeeReq = $request->only(['name', 'email', 'password', 'position', 'branch']);
    $employee = $this->employeeRebo->store($employeeReq);
    return new EmployeeResource($employee);
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
      'password',
      'position',
      'branch'
    ]);
    $employeeData = $this->employeeRebo->update($employee, $employeeinputs);
    return new EmployeeResource($employeeData);
  }


  public function destroy(User $employee)
  {
    $this->authorize('delete', $employee->userable_type === 'App\Employee' ? $employee->userable : null);
    $status = $employee->userable->delete();
    if ($status) {
      return response()->json(["data" => "deleted successfuly"]);
    }
    return response()->json(["data" => "Employee doesn't exist"]);
  }
}
