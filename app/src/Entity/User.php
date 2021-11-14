<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $username;
    private string $emailAddress;
    private string $password;
    private string $profileImage;
    private array $roles;

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress= $emailAddress;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getProfileImage(): string
    {
        return $this->profileImage;
    }

    public function setProfileImage(string $profileImage): void
    {
        $this->profileImage = $profileImage;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getUserIdentifier(): string
    {
        return $this->emailAddress;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void {}
}