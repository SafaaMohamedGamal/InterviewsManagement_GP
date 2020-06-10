<?php

namespace App\Http\Repositories;

use App\User;
use App\Employee;
use Illuminate\Support\Facades\Hash;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;

class EmployeeRepository implements UserRepositoryInterface
{

    private $userRebo;
    public function __construct(UserRepositoryInterface $userRebository)
    {
        $this->userRebo = $userRebository;
    }

    public function getAll($request)
    {
        
    }

    public function get($employeeReq)
    {
        
    }

    public function update($user, $req)
    {
        $userEmployee = $this->userRebo->update($user->id, $req);
        $userEmployee = $user->userable;
        $status = $userEmployee->update([
            "position" => isset($req["position"]) ? $req["position"] : $userEmployee->position,
            "branch" => isset($req["branch"]) ? $req["branch"] : $userEmployee->branch,
        ]);
        return $userEmployee;
    }

    public function store($employeeReq)
    {
        $userEmployee = $this->userRebo->store($employeeReq);
        $Employee = Employee::create($employeeReq);
        $Employee->user()->save($userEmployee);
        $userEmployee->assignRole('employee');
        return $Employee;
    }
}
