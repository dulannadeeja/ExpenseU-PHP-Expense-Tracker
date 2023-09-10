<?php

namespace App\Core\Models;

class Transaction extends Model
{
    private int $id;
    private int $userId;
    private int $categoryCode;
    private string $description;
    private \DateTime $transactionDate;
    private float $amount;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

}