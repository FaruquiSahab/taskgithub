<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Socialite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;



class AuthGoogleController extends Controller
{
    public function __construct()
    {
        $this->middleware('authorize');
    }

	// redirect users to the Google

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }


    // Handle callback from Google.
    public function callback(Request $request)
    {
        try {

            $googleUser = Socialite::driver('google')->user();
            $existUser = User::where('email',$googleUser->email)->first();

            // check if user already exists
            if($existUser) {

                // exists user 2fa enabled
                if ($existUser->is_auth == 1) {
                    Auth::logout();
                    $request->session()->put('2fa:user:id', $existUser->id);
                    return redirect('2fa/validate');
                }

                // exists user 2fa disabled
                elseif($existUser->is_auth == 0) {
                    Auth::loginUsingId($existUser->id);
                    $existUser->update([
                    	'name' => $googleUser->name,
                    	'avatar' => $googleUser->avatar,
                    	'avatar_original' => $googleUser->avatar_original,
                    ]);
                }
            }
            
            // new google user
            else
            {
                $user = new User;
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->google_id = $googleUser->id;
                $user->avatar = $googleUser->avatar;
                $user->avatar_original = $googleUser->avatar_original;
                $user->timezone = User::TimeZone();
                $digits = 6;
                $user->password = md5(str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT));
                $user->save();
                Auth::loginUsingId($user->id);
            }
            return redirect()->to('/home');
        } 
        catch (Exception $e) {
            return $e;
        }
    }
}