<?php

declare(strict_types=1);

namespace App\Entity;

class HouseSearch
{
    private ?int $price = null;
    private ?int $minSurface = null;

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    public function setMinSurface(int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }
}
