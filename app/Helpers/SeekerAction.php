<?php

namespace App\Helpers;

use App\Seeker;
use Illuminate\Support\Facades\Storage;

class SeekerAction
{
    public static function update($req, $user)
    {
        $userSeeker = $user->userable;
        if(isset($req['cv'])){
          $cvName = time().'_'.$req['cv']->getClientOriginalName();
          $path = $req['cv']->storeAs(
            'public/cvs', $cvName
          );
          if($userSeeker['cv']){
            echo $userSeeker['cv'];
            Storage::delete($userSeeker['cv']);
          }
        }
        $status = $userSeeker->update(
          [
          'address' => isset($req["address"]) ? $req["address"] : $userSeeker->address,
          'city' => isset($req["city"]) ? $req["city"] : $userSeeker->city,
          'seniority' => isset($req["seniority"]) ? $req["seniority"] : $userSeeker->seniority,
          'expYears' => isset($req["expYears"]) ? $req["expYears"] : $userSeeker->expYears,
          'currentJob' => isset($req["currentJob"]) ? $req["currentJob"] : $userSeeker->currentJob,
          'currentSalary' => isset($req["currentSalary"]) ? $req["currentSalary"] : $userSeeker->currentSalary,
          'expectedSalary' => isset($req["expectedSalary"]) ? $req["expectedSalary"] : $userSeeker->expectedSalary,
          'cv' => isset($req["cv"]) ? $path : $userSeeker->cv,
          'phone' => isset($req["phone"]) ? $req["phone"] : $userSeeker->phone,
          ]);
        return $status;
    }

}
