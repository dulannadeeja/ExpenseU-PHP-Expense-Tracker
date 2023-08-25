<?php

namespace App\Models;

class Receipt
{
    private int $id;
    private int $transactionId;
    private string $fileName;
    private \DateTime $createdAt;

}