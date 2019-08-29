<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class Event extends Model
{
    
    protected $fillable = ['title', 'start_time'];
    protected $hidden = [];

    

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartTimeAttribute($input)
    {
        if ($input != null && $input != '') {
            // dd(self::convertToUTC($input, 'Europe/London', config('app.date_format') . 'Y-m-d H:i:s'));
            $this->attributes['start_time'] =
                self::convertToUTC($input, auth()->user()->timezone, config('app.date_format') . 'Y-m-d H:i:s');
        } else {
            $this->attributes['start_time'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartTimeAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . 'Y-m-d H:i:s');

        if ($input != $zeroDate && $input != null) {
            // dd($input);
            // dd(auth()->user()->timezone);
            // dd(self::convertFromUTC($input, 'Europe/London', config('app.date_format') . ' H:i:s'));
            return self::convertFromUTC($input, auth()->user()->timezone, config('app.date_format') . 'Y-m-d H:i:s');
        } else {
            return '';
        }
    }

    // convert UTC to user timezone time (UTC->TIMEZONE)
    public static function convertFromUTC($timestamp, $timezone, $format = 'Y-m-d H:i:s')
	{
        $date = new DateTime($timestamp, new DateTimeZone('UTC'));

        $date->setTimezone(new DateTimeZone($timezone));

        return $date->format($format);
    } 

	// convert user timezone time to UTC (TIMEZONE->UTC) 
    public static function convertToUTC($timestamp, $timezone, $format = 'Y-m-d H:i:s')
    {
    	$date = new DateTime($timestamp, new DateTimeZone($timezone));

        $date->setTimezone(new DateTimeZone('UTC'));

        return $date->format($format);
    }
}
