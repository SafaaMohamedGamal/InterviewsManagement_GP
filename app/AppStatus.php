<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppStatus extends Model
{
    protected $fillable=['name','description'];

    public static function newStatus()
    {
        return self::where('name', 'New')->first();
    }
}
