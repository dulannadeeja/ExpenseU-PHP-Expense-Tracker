<?php
declare(strict_types=1);

namespace App;

use App\Core\Application;

class migrations{
    private \PDO $pdo;
    public function __construct()
    {
        $this->pdo = Application::$app->database->pdo;
    }

    //get all files in migrations folder
    private function getAllMigrationFiles(){
        $migrationDir = Application::$rootDir . '/Migrations';
        $files = scandir($migrationDir);
        return array_diff($files, ['.', '..']);
    }

    //create migration table if not exists
    private function createMigrationTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    //get all migrations from migrations table
    private function getAppliedMigrations(): bool|array
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    //save migration to migrations table
    private function saveMigration(string $migration): void
    {
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
        $statement->bindValue(':migration', $migration);
        $statement->execute();
    }

    //run migrations
    public function runMigrations(): void
    {
        $newMigrations = [];
        $this->createMigrationTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $files = $this->getAllMigrationFiles();
        if($files === false){
            echo "No migration files found.\n";
            exit;
        }
        if(empty($appliedMigrations)){
            $newMigrations = $files;
        }else{
            foreach($files as $file){
                if(!in_array($file, $appliedMigrations)){
                    $newMigrations[] = $file;
                }
            }
        }
        if($newMigrations){
            foreach($newMigrations as $migration){
                require_once Application::$rootDir . '/Migrations/' . $migration;
                $className = pathinfo($migration, PATHINFO_FILENAME);
                // Build the fully qualified class name
                $fullyQualifiedClassName = '\\App\\Migrations\\' . $className;
                $instance = new $fullyQualifiedClassName();
                $instance->up();
                $this->saveMigration($migration);
            }
            echo "migrations applied successfully.\n";
        }else{
            echo "Nothing to migrate.\n";
        }
    }


}