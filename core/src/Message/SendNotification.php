<?php

declare(strict_types=1);

namespace App\Message;


class SendNotification
{
    public string $message;
    public array $users;

    public function __construct(string $message, array $users)
    {
        $this->message = $message;
        $this->users = $users;
    }
}