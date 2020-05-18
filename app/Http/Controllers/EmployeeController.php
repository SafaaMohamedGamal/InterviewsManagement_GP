<?php

namespace App\Http\Controllers;

use App\Employee;
use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index()
    {
      $userEmployee = Employee::all();
        return [
          "user" => $userEmployee,
            // "type" => $userEmployee[0]->user,
        ];
    }


    public function store(Request $request)
    {
        $user = $request->only(['name', 'email', 'password']);
        $userEmployee = User::create($user);
        $Employee = Employee::create();

        $Employee->user()->save($userEmployee);
        return [
          "user" => $userEmployee,
          "employee" => $Employee
        ];
    }


    public function show($employee)
    {
        $user = User::find($employee);
        return [
          "employee" => $user,
          "user" => $user->userable
        ];
    }

    public function update(Request $request, $employee)
    {
        $employeeinputs = $request->only([
          'position',
          'branch'
        ]);
        $user = User::find($employee);

        $employee = $user->userable;
        $status = $employee->update([
          'position' => $employeeinputs['position'],
          'branch' => $employeeinputs['branch']
            ]);

        return [
          "user" => $user,
          // "status" => $status
        ];
    }


    public function destroy($employee)
    {
      $user = User::find($employee);
      $employee = $user->userable;
      $employee->user()->delete();
      return true;
    }
}
