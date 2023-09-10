<?php

namespace App\Core\Models\Enum;

enum ValidationRule: string
{
    case required='required';
    case email='email';
    case min='min';
    case max='max';
    case match='match';
    case unique='unique';
}