<?php

namespace App\Core;

class Database
{
    public function __construct($config)
    {
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];


    }
}