<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title','description','available','years_exp','seniority'];

    public function requirements()
    {
        return $this->hasMany('App\JobRequirement');
    }
}
