<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = [
        'application_id',
        'emp_id',
        'level_id',
        'date',
        'seeker_review',
        'company_review',
        'zoom',

    ];

    public function level()
    {
        return $this->belongsTo('App\Level');
    }

    public function application()
    {
        return $this->belongsTo('App\Application');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'emp_id');
    }
}
