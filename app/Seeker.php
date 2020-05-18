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
       'cv'
   ];

    public function user()
    {
        return $this->morphOne('App\User', 'userable');
        // return $this->belongsTo('App\User');
    }
}
