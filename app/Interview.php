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
        'zoom   ',

    ];
}
