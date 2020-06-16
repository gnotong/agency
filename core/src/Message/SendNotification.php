<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\Contact;

class SendNotification
{
    public Contact $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
}