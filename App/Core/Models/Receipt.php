<?php

namespace App\Core\Models;

class Receipt extends Model
{
    private int $id;
    private int $transactionId;
    private string $fileName;
    private \DateTime $createdAt;

}