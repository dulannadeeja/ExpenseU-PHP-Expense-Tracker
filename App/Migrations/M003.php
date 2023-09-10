<?php
declare(strict_types=1);

namespace App\Migrations;

use App\Core\Application;

class M003
{
    private \PDO $pdo;
    public function __construct()
    {
        $this->pdo = Application::$app->database->pdo;
    }
    public function up(): void
    {
        //create receipt table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS receipt (
            id INT AUTO_INCREMENT PRIMARY KEY,
            transaction_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function down(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS receipt;");
    }
}