<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\Contact;

class SendNotification
{
    public ?string $firstName = null;
    public ?string $lastName  = null;
    public ?string $phone     = null;
    public ?string $email     = null;
    public ?string $message   = null;
    public ?string $houseName = null;

    public function __construct(Contact $contact)
    {
        $this->firstName = $contact->getFirstName();
        $this->lastName  = $contact->getLastName();
        $this->phone     = $contact->getPhone();
        $this->email     = $contact->getEmail();
        $this->message   = $contact->getMessage();
        $this->houseName = $contact->getHouseName();
    }
}