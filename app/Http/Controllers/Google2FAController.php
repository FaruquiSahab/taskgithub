<?php

namespace App\Http\Controllers;

use Crypt;
use Google2FA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \ParagonIE\ConstantTime\Base32;

class Google2FAController extends Controller
{
    use ValidatesRequests;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function enableTwoFactor(Request $request)
    {
    	//get user
        $user = $request->user();

        //generate new secret
        $secret = $this->generateSecret();

        
        //encrypt and then save secret
        $user->google2fa_secret = Crypt::encrypt($secret);
        $user->is_auth = 1;
        $user->save();

        //generate image for QR barcode
        $imageDataUri = Google2FA::getQRCodeInline(
            $request->getHttpHost(),
            $user->email,
            $secret,
            200
        );

        return view('2fa/enableTwoFactor', ['image' => $imageDataUri,
            'secret' => $secret]);
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function disableTwoFactorForm(Request $request)
    {
    	//get user
        $user = $request->user();
        $id = $user->id;

        // if user is google user
        if($user->google_id > 0){
        	return $this->disableTwoFactor($request);
    	}
    	return view('2fa/disableTwoFactorForm',compact('id'));
    }


    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function disableTwoFactor(Request $request)
    {
    	//get user
        $user = $request->user();

        // if user is google user
        if($user->google_id > 0){
        	//make secret column blank
		       $user->google2fa_secret = null;
		       $user->is_auth = 0;
		       $user->save();
	    }
	    // if user is our user
	    else{
	    	// validate request
	    	$this->validate($request, [
	            'id' => 'required',
	            'password' => 'required'
	        ]);
	    	// if password match
	    	if (Hash::check($request->input('password'), $user->password)) {
		        //make secret column blank
		        $user->google2fa_secret = null;
		        $user->is_auth = 0;
		        $user->save();
	    	}
	    	// password did't match
	    	else{
	    		return redirect()->back()->with(['error'=>'Credentials Did Not Match Our Records']);
	    	}
		}

        return view('2fa/disableTwoFactor');
    }

    /**
     * Generate a secret key in Base32 format
     *
     * @return string
     */
    private function generateSecret()
    {
    	// generate random bytes
        $randomBytes = random_bytes(10);

        return Base32::encodeUpper($randomBytes);
    }
}