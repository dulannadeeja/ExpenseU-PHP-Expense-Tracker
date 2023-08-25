<?php

namespace App\Models;

class Category
{
    private int $id;
    private int $userId;
    private string $name;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
}