<?php

namespace App\Dto;

class UserDto
{
    private int $id;

    private string $username;

    private array $roles;

    private string $email;

    private bool $activate = true;

    private bool $banned = false;

    private UserDetailsDto|null $UserDetails = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function isActivate(): bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): void
    {
        $this->activate = $activate;
    }

    public function isBanned(): bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): void
    {
        $this->banned = $banned;
    }

    public function getUserDetails(): ?UserDetailsDto
    {
        return $this->UserDetails;
    }

    public function setUserDetails(?UserDetailsDto $UserDetails): void
    {
        $this->UserDetails = $UserDetails;
    }

    // private Collection $questions;
}
