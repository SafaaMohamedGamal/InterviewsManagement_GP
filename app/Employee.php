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
        return $this->hasMany('App\Interview', 'emp_id');
    }

    protected static function booted()
    {
        static::deleting(function ($employee) {
            $employee->interviews()->delete();
            $employee->user->removeRole('employee');
            $employee->user()->delete();
        });
    }
}
