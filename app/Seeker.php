<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected static function booted()
    {
        static::deleting(function ($seeker) {

          foreach ($seeker->applications as $app) {
              $app->interviews()->delete();
          }
          $seeker->applications()->delete();

          $seeker->contacts()->delete();

          if ($seeker['cv']) {
              Storage::delete('public/cvs/' . $seeker->cv);
          }

          $seeker->user()->delete();
        });
    }
}
