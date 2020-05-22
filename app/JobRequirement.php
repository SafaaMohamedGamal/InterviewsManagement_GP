<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRequirement extends Model
{
    protected $fillable = ['name','job_id'];

    public function job()
    {
        return $this->belongsTo("App\Job");
    }
}
