<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = [
        'data', 'seeker_id', 'contact_types_id',
    ];

    public function contactType(){
        return $this->belongsTo('App\ContactType', 'contact_types_id');
    }

    public function seeker(){
        return $this->belongsTo('App\Seeker', 'seeker_id');
    }
}
