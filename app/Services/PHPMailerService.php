<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    protected $mailer;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($to, $subject, $body, $attachment="")
    {
        try {
            // Add recipient
            $this->mailer->addAddress($to);

            // Email content
            $this->mailer->isHTML(true);                                  // Set email format to HTML
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            if($attachment)
            {
                $this->mailer->addAttachment($attachment);
            }
            // Send the email
            $this->mailer->send();

            return "Message has been sent";
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}
