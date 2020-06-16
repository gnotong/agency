<?php

declare(strict_types=1);

namespace App\Service;

use App\Message\SendNotification;
use Twig\Environment;

class Notifier
{
    private \Swift_Mailer $mailer;
    private Environment   $environment;

    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {
        $this->mailer      = $mailer;
        $this->environment = $environment;
    }

    public function notify(SendNotification $notification)
    {
        $message = (new \Swift_Message('Agency: ' . $notification->houseName))
            ->setFrom('noreply@agency.fr')
            ->setTo('gabriel.notong@gmail.com')
            ->setReplyTo($notification->email)
            ->setBody(
                $this->environment->render('email/contact.html.twig', [
                    'contact_name' => $notification->firstName . ' ' . $notification->lastName,
                    'message' => $notification->message,
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}