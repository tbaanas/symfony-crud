<?php

namespace App\Entity;

use App\Repository\WarningsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WarningsRepository::class)]
class Warnings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $warnings = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $warningMessage = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $loginAttempts = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastBadLogin = null;

    #[ORM\Column(nullable: true)]
    private ?bool $banned = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $banDate = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $banReason = null;

    #[ORM\OneToOne(inversedBy: 'warnings', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWarnings(): ?int
    {
        return $this->warnings;
    }

    public function setWarnings(?int $warnings): self
    {
        $this->warnings = $warnings;

        return $this;
    }

    public function getWarningMessage(): ?string
    {
        return $this->warningMessage;
    }

    public function setWarningMessage(?string $warningMessage): self
    {
        $this->warningMessage = $warningMessage;

        return $this;
    }

    public function getLoginAttempts(): ?int
    {
        return $this->loginAttempts;
    }

    public function setLoginAttempts(?int $loginAttempts): self
    {
        $this->loginAttempts = $loginAttempts;

        return $this;
    }

    public function getLastBadLogin(): ?\DateTimeInterface
    {
        return $this->lastBadLogin;
    }

    public function setLastBadLogin(?\DateTimeInterface $lastBadLogin): self
    {
        $this->lastBadLogin = $lastBadLogin;

        return $this;
    }

    public function isBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(?bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    public function getBanDate(): ?\DateTimeInterface
    {
        return $this->banDate;
    }

    public function setBanDate(?\DateTimeInterface $banDate): self
    {
        $this->banDate = $banDate;

        return $this;
    }

    public function getBanReason(): ?string
    {
        return $this->banReason;
    }

    public function setBanReason(?string $banReason): self
    {
        $this->banReason = $banReason;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
