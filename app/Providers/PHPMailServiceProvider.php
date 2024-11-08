<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PHPMailer\PHPMailer\PHPMailer;

class PHPMailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */ 
    public function register()
    {
        $this->app->singleton(PHPmailer::class, function ($app) {
         $mail = new PHPmailer(true);
         $mail->isSMTP();
         $mail->Host       = env('MAIL_HOST');
         $mail->SMTPAuth   = true;
         $mail->Username   = env('MAIL_USERNAME');
         $mail->Password   = env('MAIL_PASSWORD');
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         $mail->Port       = env('MAIL_PORT');
         $mail->setFrom(env('MAIL_FROM_ADDRESS'), 'Six Cash');

         return $mail;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        
    }
}
