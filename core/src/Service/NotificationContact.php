<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Contact;
use Twig\Environment;

class NotificationContact
{
    private \Swift_Mailer $mailer;
    private Environment $environment;

    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Agency: ' . $contact->getHouse()->getTitle()))
            ->setFrom('noreply@agency.fr')
            ->setTo('gabriel.notong@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody(
                $this->environment->render('email/contact.html.twig', [
                    'contact' => $contact
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}