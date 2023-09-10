<?php

namespace App\Core\Exceptions;

use http\Message;
use Throwable;

class SessionException extends \Exception
{
    public function __construct(string $string, $code = 500)
    {
        parent::__construct($string, $code);
    }
}