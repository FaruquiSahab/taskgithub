<?php

namespace App\Http\Controllers;

use App\Authorize;
use App\Http\Controllers\Controller;
use App\Mail\AuthorizeDevice as AuthorizeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class AuthorizeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Validate the token for the Authorization.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token = null)
    {
        if (Authorize::validateToken($token)) {
            return Redirect::route('home')->with([
                'status' => 'Awesome ! you are now authorized !',
            ]);
        }
        return Redirect::route('login')->with([
            'error' => "Oh snap ! the authorization token is either expired or invalid. Click on Email didn't arraive ? again",
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     * Resend Email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if (Authorize::inactive() && auth()->check()) {
            $authorize = Authorize::make()
                ->resetAttempt();
            Mail::to($request->user())
                ->send(new AuthorizeMail($authorize));
            $authorize->increment('attempt');
            return view('auth.authorize');
        }
    }
}
