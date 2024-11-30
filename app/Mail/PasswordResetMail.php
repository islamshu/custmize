<?php
namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $otp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $otp)
    {
        $this->client = $client;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->subject('Reset Your Password')
                    ->view('mail.password_reset')->with([
                        'otp' => $this->otp
                     ]);
    }
}