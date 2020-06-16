<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3, max=100)
     */
    private ?string $firstName = null;
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3, max=100)
     */
    private ?string $lastName = null;
    /**
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/[0-9]{10}/")
     */
    private ?string $phone = null;
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private ?string $email = null;
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    private ?string $message = null;

    private ?string $houseName;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getHouseName(): ?string
    {
        return $this->houseName;
    }

    public function setHouseName(?string $houseName): self
    {
        $this->houseName = $houseName;
        return $this;
    }
}