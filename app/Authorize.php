<?php

namespace App;

use App\Browser;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Authorize extends Model
{
	protected $primaryKey = 'id';
    /**
     * @var string
     */
    protected $table = 'authorizes';
    /**
     * @var boolean
     */
    public $timestamps = true;
    /**
     * @var array
     */
    protected $dates = ['authorized_at', 'deleted_at'];
    /**
     * @var string
     */
    protected $fillable = [
        'user_id', 'authorized', 'token', 'ip_address', 'browser', 'os', 'location', 'attempt', 'authorized_at',
    ];

    /**
     * Return Currently Requested Active User 
     */
    public static function active()
    {	
    	$browser = new Browser;
    	$information = json_decode(User::information(),true);
    	$ip = $information['query'];
        return with(new self)
        	->where('user_id', Auth::id())
            ->where('ip_address', $ip)
            ->where('authorized', true)
            ->where('browser', $browser->getBrowser())
            ->where('authorized_at', '<', Carbon::tomorrow())
            ->first();
    }

    /**
     * Reset Login Attempts
     */
    public function resetAttempt()
    {
        $this->update(['attempt' => 0]);
        return $this;
    }

    /**
     * Number Of Attempt
     */
    public function noAttempt()
    {
        return $this->attempt < 1;
    }

    /**
     * Validate Received Token 
     */
    public static function validateToken($token = null)
    {
        $query = self::where([
            'token' => $token,
        ])->first();
        if (!is_null($query)) {
            $query->update([
                'authorized' => true,
                'authorized_at' => now(),
            ]);
            return self::active();
        }
    }

    /**
     * Check If User Is New Or Existing With Details
     */
    public static function make()
    {
    	$browser = new Browser;
    	$information = json_decode(User::information(),true);
    	$ip = $information['query'];
        return self::firstOrCreate([
            'ip_address' => $ip,
            'authorized' => false,
            'browser'	=> $browser->getBrowser(),
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Checking InActive User
     */
    public static function inactive()
    {
        $query = self::active();
        return $query ? null : true;
    }
}
