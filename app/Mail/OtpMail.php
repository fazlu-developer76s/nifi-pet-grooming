<?php

// app/Mail/OtpMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    /**
     * Create a new message instance.
     *
     * @param string $otp
     * @return void
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.otp') // specify the view for the email
            ->subject('Your OTP Code') // set the email subject
            ->with('otp', $this->otp) // pass OTP to the view
            ->from('website.fazlu@gmail.com', 'Website fazlu') // From address
            ->replyTo('website.fazlu@gmail.com', 'Website fazlu'); // From address
            // ->replyTo('reply-to@example.com', 'Reply Name') // Reply-To address
            // ->cc('cc@example.com', 'CC Name') // CC address
            // ->bcc('bcc@example.com', 'BCC Name'); // BCC address
    }
}
