<?php

// autoload
require_once dirname(__DIR__) . '/vendor/autoload.php';

// load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



