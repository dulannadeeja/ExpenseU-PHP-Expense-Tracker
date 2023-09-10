<?php

// autoload
use App\Core\Application;
use App\Core\Controllers\AuthController;
use App\Core\Controllers\SiteController;
use App\migrations;

require_once dirname(__DIR__) . '/../vendor/autoload.php';

// load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// initializing the application
$app = new Application(dirname(__DIR__), [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ],
    'session'=>[
        'session_name'=> $_ENV['SESSION_NAME'],
        'session_lifetime'=> $_ENV['SESSION_LIFETIME'],
        'session_path'=> $_ENV['SESSION_PATH'],
        'session_domain'=> $_ENV['SESSION_DOMAIN'],
        'session_secure'=> $_ENV['SESSION_SECURE'],
        'session_httponly'=> $_ENV['SESSION_HTTPONLY'],
        'session_samesite'=> $_ENV['SESSION_SAMESITE']
    ]
]);

// define routes
$app->router->get('/',[SiteController::class,'index']);
$app->router->get('/sign_up',[AuthController::class,'signUp']);
$app->router->post('/sign_up',[AuthController::class,'signUp']);
$app->router->get('/sign_in',[AuthController::class,'signIn']);
$app->router->post('/sign_in',[AuthController::class,'signIn']);
$app->router->get('/sign_out',[AuthController::class,'signOut']);

// run migrations
$migration = new migrations();
$migration->runMigrations();

// resolve paths
echo $app->run();
