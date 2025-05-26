<?php
// app/Services/FirebaseService.php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $serviceAccountPath = storage_path('app\firebase\google-services.json');

        $factory = (new Factory)->withServiceAccount($serviceAccountPath);

        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification(array $deviceTokens, array $notificationData)
    {
        $message = CloudMessage::new()
            ->withNotification(Notification::create(
                $notificationData['title'],
                $notificationData['body']
            ));

        foreach ($deviceTokens as $token) {
            $this->messaging->send($message->withChangedTarget('token', $token));
        }

        return true;
    }
}
