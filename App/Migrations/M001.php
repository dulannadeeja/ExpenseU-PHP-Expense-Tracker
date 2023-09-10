<?php
declare(strict_types=1);

namespace App\Migrations;

use App\Core\Application;

class M001
{
    private \PDO $pdo;
    public function __construct()
    {
        $this->pdo = Application::$app->database->pdo;
    }
    public function up(): void
    {
        // create user table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function down(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS user;");
    }

}