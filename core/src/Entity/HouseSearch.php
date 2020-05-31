<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class HouseSearch
{
    private ?int $price = null;
    private ?int $minSurface = null;
    private Collection $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

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

    /**
     * @return ArrayCollection|Option[]
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    public function setOptions(ArrayCollection $options): self
    {
        $this->options = $options;

        return $this;
    }
}
