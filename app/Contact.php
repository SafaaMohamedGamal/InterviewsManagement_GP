<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = [
        'data', 'seeker_id', 
    ];

    public function contactTypes(){
        return $this->belongsTo('App\ContactType');
    }
}
