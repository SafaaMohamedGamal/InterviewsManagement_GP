<?php

namespace App\Helpers;

use App\Employee;

class EmployeeAction
{
    public static function update($req, $user)
    {
        $userEmployee = $user->userable;
        $status = $userEmployee->update([
            "position" => isset($req["position"]) ? $req["position"] : $userEmployee->position,
            "branch" => isset($req["branch"]) ? $req["branch"] : $userEmployee->branch,
        ]);
        return $status;
    }

}
