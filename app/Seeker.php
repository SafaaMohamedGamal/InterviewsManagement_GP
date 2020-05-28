<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    //
    protected $fillable = [
       'address',
       'city',
       'seniority',
       'expYears',
       'currentJob',
       'currentSalary',
       'expectedSalary',
       'cv',
       'phone',
       'isVerified'
   ];

    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function applications()
    {
        return $this->hasMany('App\Application');
    }
}
