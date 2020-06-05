<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HouseRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=HouseRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *      fields={"title"},
 *     message="This title is already in use."
 * )
 * @Vich\Uploadable
 */
class House
{
    const HEAT_ELECTRIC = 'electric';
    const HEAT_GAS      = 'gas';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="5", max="255")
     */
    private ?string $title = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $surface = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $rooms = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $bedrooms = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $floor = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $price = null;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(callback="getHeats")
     */
    private ?string $heat = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $city = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $address = null;

    /**
     * @ORM\Column(type="string")
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private ?string $zipCode = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $sold = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $imageName = null;

    /**
     * @Vich\UploadableField(mapping="house_image", fileNameProperty="imageName")
     * @Assert\Image(
     *     mimeTypes="image/jpeg"
     * )
     */
    private ?File $imageFile = null;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="houses")
     */
    private Collection $options;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Attachment::class, mappedBy="house", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid()
     */
    private Collection $attachments;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->options   = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $this->slug = (Slugify::create())->slugify($this->title);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
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

    public function getHeat(): ?string
    {
        return $this->heat;
    }

    public function setHeat(string $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public static function getHeats(): array
    {
        return [self::HEAT_ELECTRIC, self::HEAT_GAS];
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addHouse($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            $option->removeHouse($this);
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->setUpdatedAt(new \DateTimeImmutable());
        }

        return $this;
    }

    /**
     * @return Collection|Attachment[]
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $image): self
    {
        if (!$this->attachments->contains($image)) {
            $this->attachments[] = $image;
            $image->setHouse($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $image): self
    {
        if ($this->attachments->contains($image)) {
            $this->attachments->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getHouse() === $this) {
                $image->setHouse(null);
            }
        }

        return $this;
    }
}
