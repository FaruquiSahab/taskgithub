<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','google2fa_secret','timezone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
    * Set attribute timezone
    */
    public function setTimezone($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['timezone'] = self::TimeZone();
        }
        else{
            $this->attributes['timezone'] = 'Europe/London';
        }
    }


    public static function TimeZone()
    {
        $ip = file_get_contents("http://ipecho.net/plain");
        $url = 'http://ip-api.com/json/'.$ip;
        $tz = file_get_contents($url);
        $tz = json_decode($tz,true)['timezone'];
        return $tz;
    }

    public static function information()
    {
        $ip = file_get_contents("http://ipecho.net/plain");
        $url = 'http://ip-api.com/json/'.$ip;
        $tz = file_get_contents($url);
        return $tz;
    }
}
