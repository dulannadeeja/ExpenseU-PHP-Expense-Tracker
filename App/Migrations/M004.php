<?php
declare(strict_types=1);

namespace App\Migrations;

use App\Core\Application;

class M004
{
    private \PDO $pdo;
    public function __construct()
    {
        $this->pdo = Application::$app->database->pdo;
    }
    public function up(): void
    {
        //create transaction table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS transaction (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            category_code INT NOT NULL,
            description VARCHAR(255) NOT NULL,
            transaction_date DATETIME NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function down(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS transaction;");
    }
}