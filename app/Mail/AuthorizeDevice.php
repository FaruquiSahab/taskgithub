<?php

namespace App\Mail;

use App\Browser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sujip\Ipstack\Ipstack;

class AuthorizeDevice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    protected $authorize;
    /**
     * Create a new message instance.
     *
     * @param $authorize
     *  @return void
     */
    public function __construct($authorize)
    {
        // object
        $this->authorize = $authorize;
        // Browser Class Obj
        $this->browser = new Browser;
    }
    
    /**
     * @return mixed
     */
    public function setBrowser()
    {
        $this->authorize->browser = $this->browser->getBrowser();
        return $this;
    }
    /**
     * @return mixed
     */
    public function setToken()
    {
        $this->authorize->token = guid();
        return $this;
    }
    /**
     * @return mixed
     */
    public function setLocation()
    {
        $api_key = '3b2c5e2fc9098382f9ff2c20d733d1e2';
        $location = with(new Ipstack(
            $this->authorize->ip_address,$api_key
        ))->formatted();
        $this->authorize->location = $location;
        return $this;
    }
    /**
     * @return mixed
     */
    public function setPlatform()
    {
        $this->authorize->os = $this->browser->getPlatform();
        return $this;
    }
    public function saveAuthorize()
    {
        $this->authorize->save();
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->setBrowser()
            ->setToken()
            ->setLocation()
            ->setPlatform()
            ->saveAuthorize();
        return $this
            ->view('emails.auth.authorize')
            ->with(['authorize' => $this->authorize]);
    }
}
