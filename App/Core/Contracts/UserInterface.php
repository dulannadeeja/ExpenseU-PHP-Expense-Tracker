<?php

namespace App\Core\Contracts;

interface UserInterface
{
    public function getID(): int;
    public function getPassword(): string;
    public function getDisplayName(): string;
}