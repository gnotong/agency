<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\House;
use Cocur\Slugify\Slugify;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AttachmentUploadSubscriber implements EventSubscriber
{

    private Slugify $slugify;
    private string  $imagePath;

    public function __construct(string $imagePath)
    {
        $this->slugify = Slugify::create();
        $this->imagePath = $imagePath;
    }
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $house = $eventArgs->getEntity();
        if (!$house instanceof House) {
            return;
        }

        if ($house->getAttachments()->count() <= 0) {
            return;
        }

        foreach ($house->getAttachments() as $attachment) {
            $file = $attachment->getImageFile();
            if (null == $file) {
                continue;
            }
            $fileName = $this->getUniqueFileName($file);
            $attachment->setImage($fileName);

            $file->move($this->imagePath, $fileName);
        }
    }

    private function getUniqueFileName(UploadedFile $file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugify->slugify($originalName);

        return $safeFileName . '-' . uniqid() . '.' . $file->guessExtension();
    }
}