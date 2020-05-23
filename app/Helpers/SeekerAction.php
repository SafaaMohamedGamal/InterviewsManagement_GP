<?php

namespace App\Helpers;

use App\Seeker;

class SeekerAction
{
    public static function update($req, $user)
    {
        $userSeeker = $user->userable;
        var_dump($userSeeker->seniority);
        $status = $userSeeker->update(
          [
          'address' => isset($req["address"]) ? $req["address"] : $userSeeker->address,
          'city' => isset($req["city"]) ? $req["city"] : $userSeeker->city,
          'seniority' => isset($req["seniority"]) ? $req["seniority"] : $userSeeker->seniority,
          'expYears' => isset($req["expYears"]) ? $req["expYears"] : $userSeeker->expYears,
          'currentJob' => isset($req["currentJob"]) ? $req["currentJob"] : $userSeeker->currentJob,
          'currentSalary' => isset($req["currentSalary"]) ? $req["currentSalary"] : $userSeeker->currentSalary,
          'expectedSalary' => isset($req["expectedSalary"]) ? $req["expectedSalary"] : $userSeeker->expectedSalary,
          'cv' => isset($req["cv"]) ? $req["cv"] : $userSeeker->cv,
          'phone' => isset($req["phone"]) ? $req["phone"] : $userSeeker->phone,
          ]);
        return $status;
    }

}
