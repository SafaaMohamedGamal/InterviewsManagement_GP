<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['seeker_id','job_id','appstatus_id'];
    public function seeker()
    {
        return $this->belongsTo('App\Seeker');
    }
    public function job()
    {
        return $this->belongsTo('App\Job');
    }
    public function status()
    {
        return $this->belongsTo('App\AppStatus', 'appstatus_id');
    }

    public function interviews()
    {
        return $this->hasMany('App\Interview');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($application) {
            // called BEFORE delete()
            $application->interviews()->delete();
        });
    }
}
