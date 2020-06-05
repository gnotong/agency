<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\House;
use Cocur\Slugify\Slugify;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AttachmentCleanerSubscriber implements EventSubscriber
{
    private Slugify $slugify;
    private string  $imagePath;
    private Filesystem $filesystem;

    public function __construct(string $imagePath, Filesystem $filesystem)
    {
        $this->slugify = Slugify::create();
        $this->imagePath = $imagePath;
        $this->filesystem = $filesystem;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::preRemove,
            Events::preUpdate,
        ];
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
//        $house = $eventArgs->getEntity();
//        if (!$house instanceof House) {
//            return;
//        }
//
//        if ($house->getAttachments()->count() <= 0) {
//            return;
//        }
//
//        foreach ($house->getAttachments() as $attachment) {
//            $file = $attachment->getImageFile();
//            if (null == $file) {
//                continue;
//            }
//            $fileName = $this->getUniqueFileName($file);
//
//            $this->filesystem->remove($this->imagePath . '/' . $fileName);
//            $file->move($this->imagePath, $fileName);
//            $attachment->setImage($fileName);
//        }

//        dd($house);
    }

    public function preRemove(LifecycleEventArgs $eventArgs): void
    {

    }

    private function getUniqueFileName(UploadedFile $file): string
    {
//        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
//        $safeFileName = $this->slugify->slugify($originalName);
//
//        return $safeFileName . '-' . uniqid() . '.' . $file->guessExtension();
    }
}