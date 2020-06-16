<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\House;
use Doctrine\Common\Collections\Collection;

class AddAttachments
{
    public Collection $attachments;
    public House $house;

    public function __construct(Collection $attachments, House $house)
    {
        $this->attachments = $attachments;
        $this->house = $house;
    }
}