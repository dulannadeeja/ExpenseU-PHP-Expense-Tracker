<?php

namespace App\Models;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

}