<?php

namespace App\Entity;

use App\Repository\UserDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserDetailsRepository::class)]
class UserDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $gender = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registerDate = null;

    #[ORM\Column(length: 255)]
    private ?string $registerIP = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLoginDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastLoginIP = null;

    #[ORM\Column]
    private ?bool $emailNotification = null;

    #[ORM\Column]
    private ?bool $pushNotification = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatarLink = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

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

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTimeInterface $registerDate): self
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getRegisterIP(): ?string
    {
        return $this->registerIP;
    }

    public function setRegisterIP(string $registerIP): self
    {
        $this->registerIP = $registerIP;

        return $this;
    }

    public function getLastLoginDate(): ?\DateTimeInterface
    {
        return $this->lastLoginDate;
    }

    public function setLastLoginDate(?\DateTimeInterface $lastLoginDate): self
    {
        $this->lastLoginDate = $lastLoginDate;

        return $this;
    }

    public function getLastLoginIP(): ?string
    {
        return $this->lastLoginIP;
    }

    public function setLastLoginIP(?string $lastLoginIP): self
    {
        $this->lastLoginIP = $lastLoginIP;

        return $this;
    }

    public function isEmailNotification(): ?bool
    {
        return $this->emailNotification;
    }

    public function setEmailNotification(bool $emailNotification): self
    {
        $this->emailNotification = $emailNotification;

        return $this;
    }

    public function isPushNotification(): ?bool
    {
        return $this->pushNotification;
    }

    public function setPushNotification(bool $pushNotification): self
    {
        $this->pushNotification = $pushNotification;

        return $this;
    }

    public function getAvatarLink(): ?string
    {
        return $this->avatarLink;
    }

    public function setAvatarLink(?string $avatarLink): self
    {
        $this->avatarLink = $avatarLink;

        return $this;
    }
}
