<?php

namespace App\Core\Contracts;

interface AuthInterface
{
    public function getUser(): ?UserInterface;

    public function login(UserInterface $user): bool;

    public function logout(): void;

    public function isGuest(): bool;
}