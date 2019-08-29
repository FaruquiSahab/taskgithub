<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    protected $guarded = [];


    public static function age($date)
    {
    	return Carbon::parse($date)->age;
    }
}
