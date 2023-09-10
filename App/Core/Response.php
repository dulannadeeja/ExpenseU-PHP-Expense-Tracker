<?php

namespace App\Core;

use JetBrains\PhpStorm\NoReturn;

class Response
{

    // set the response status code
    public function setStatusCode(int $int): void
    {
        http_response_code($int);
    }

    // redirect to a given URL
    public function redirect(string $url): void
    {
        header("Location: " . $url);
    }
}