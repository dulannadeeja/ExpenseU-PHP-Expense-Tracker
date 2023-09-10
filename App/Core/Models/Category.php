<?php

namespace App\Core\Models;

class Category extends Model
{
    private int $id;
    private int $userId;
    private string $name;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
}