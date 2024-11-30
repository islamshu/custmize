<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirm_email extends Mailable
{
    use Queueable, SerializesModels;
   
  
    public function build()
    {
        return $this->view('mail.confirm_verfiy');
       
    }

          
      
}

