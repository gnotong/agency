<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SendNotification;
use App\Service\Notifier;

class SendNotificationHandler
{
    private Notifier $notifier;

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function __invoke(SendNotification $notification)
    {
        $this->notifier->notify($notification);
    }
}