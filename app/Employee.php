<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
      'position',
      'branch'
    ];

    public function user()
    {
      return $this->morphOne('App\User', 'userable');
    }

     public function interviews()
    {
        return $this->hasMany('App\Interview');
    }
}
