<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;
use App\Authorize;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthorizeDevice as AuthorizeMail;


class AuthorizeDevice
{
    /**
     * @var \App\Authorize
     */
    private $authorize;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        
        if (Authorize::inactive() && auth()->check())
        {
            $this->authorize = Authorize::make();
            if ($this->authorize->noAttempt()) {
                Mail::to($request->user())
                    ->send(new AuthorizeMail($this->authorize));
                $this->authorize->increment('attempt');
            }
            if ($this->timeout()) {
                auth()->guard()->logout();
                $request->session()->invalidate();
                return redirect('/')->with([
                    'status' => 'You are logged out of system, please follow the link we sent before 15 minutes to authorize your device, the link will be valid with same IP for 24hrs.',
                ]);
            }
            return response()->view('auth.authorize');
        }
        return $next($request);
    }

    /**
     * Determines if the authorize attempt is timed out.
     *
     * @return bool
     */
    private function timeout()
    {
        $waiting = $this->authorize
            ->created_at
            ->addMinutes(15);
        if (now() >= $waiting) {
            return true;
        }
        return false;
    }
}