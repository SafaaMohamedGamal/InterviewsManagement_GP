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
    public function applications()
    {
        return $this->hasMany('App\Application');
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($job) {
            // called BEFORE delete()
            $job->requirements()->delete();
            foreach ($job->applications as $app) {
                $app->interviews()->delete();
            }
            $job->applications()->delete();
        });
    }
}
