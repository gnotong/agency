<?php

declare(strict_types=1);

namespace App\Controller;

use App\Message\SendNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/messenger", name="messenger_test")
     */
    public function index(MessageBusInterface $bus, Request $request)
    {
        $users = ['pierre', 'paulette'];
        $message = $request->query->get('message', 'message data.');

        $bus->dispatch(new SendNotification($message, $users));

        return new Response('<html><body>OK.</body></html>');
    }
}