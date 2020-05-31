<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['name'];

    public function interviews()
    {
        return $this->hasMany('App\Interview');
    }
}
