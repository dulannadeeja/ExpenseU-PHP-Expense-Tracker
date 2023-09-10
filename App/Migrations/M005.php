<?php
declare(strict_types=1);

namespace App\Migrations;

use App\Core\Application;

class M005
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Application::$app->database->pdo;
    }

    public function up(): void
    {
        // Add foreign key to category table
        $this->pdo->exec("ALTER TABLE category ADD CONSTRAINT fk_category_user FOREIGN KEY (user_id) REFERENCES user(id);");

        // Add foreign key to receipt table
        $this->pdo->exec("ALTER TABLE receipt ADD CONSTRAINT fk_receipt_transaction FOREIGN KEY (transaction_id) REFERENCES transaction(id);");

        // Add foreign keys to transaction table
        $this->pdo->exec("ALTER TABLE transaction ADD CONSTRAINT fk_transaction_user FOREIGN KEY (user_id) REFERENCES user(id);");
        $this->pdo->exec("ALTER TABLE transaction ADD CONSTRAINT fk_transaction_category FOREIGN KEY (category_code) REFERENCES category(id);");
    }

    public function down(): void
    {
        // Drop foreign keys from all tables
        $this->pdo->exec("ALTER TABLE category DROP FOREIGN KEY fk_category_user;");
        $this->pdo->exec("ALTER TABLE receipt DROP FOREIGN KEY fk_receipt_transaction;");
        $this->pdo->exec("ALTER TABLE transaction DROP FOREIGN KEY fk_transaction_user;");
        $this->pdo->exec("ALTER TABLE transaction DROP FOREIGN KEY fk_transaction_category;");
    }
}
