<?php

namespace App\Dto;



class UserDto{

    private int $id;


    private string $username;

    private array $roles;

    private string $email;

    private bool $activate = true;


    private bool $banned = false;


    private UserDetailsDto|null $UserDetails = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isActivate(): bool
    {
        return $this->activate;
    }

    /**
     * @param bool $activate
     */
    public function setActivate(bool $activate): void
    {
        $this->activate = $activate;
    }

    /**
     * @return bool
     */
    public function isBanned(): bool
    {
        return $this->banned;
    }

    /**
     * @param bool $banned
     */
    public function setBanned(bool $banned): void
    {
        $this->banned = $banned;
    }

    /**
     * @return UserDetailsDto|null
     */
    public function getUserDetails(): ?UserDetailsDto
    {
        return $this->UserDetails;
    }

    /**
     * @param UserDetailsDto|null $UserDetails
     */
    public function setUserDetails(?UserDetailsDto $UserDetails): void
    {
        $this->UserDetails = $UserDetails;
    }

   // private Collection $questions;




}