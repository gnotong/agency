<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddAttachments;
use Doctrine\ORM\EntityManagerInterface;

/**
 * It attaches images to a house
 */
class AddAttachmentsHandler
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(AddAttachments $addAttachments)
    {
        $house = $addAttachments->house;
        $attachments = $addAttachments->attachments;

        foreach ($attachments as $attachment) {
            $attachment->setHouse($house);
            $this->manager->persist($attachment);
        }

        $this->manager->persist($house);
        $this->manager->flush();
    }
}