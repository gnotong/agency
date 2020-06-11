<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SendNotification;

class SendNotificationHandler
{
    public function __invoke(SendNotification $message)
    {
        foreach ($message->users as $user) {
            echo("Send notification to {$user} \n");
        }
    }
}