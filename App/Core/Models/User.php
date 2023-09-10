<?php

namespace App\Core\Models;

use App\Core\Application;
use App\Core\Contracts\UserInterface;
use App\Core\Models\Enum\ValidationRule;
use App\Core\Models\Traits\Validation;
use DateTime;
use Exception;
use PDO;

class User extends Model implements UserInterface
{
    use Validation;

    public int $id;
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public \DateTime $createdAt;
    public \DateTime $updatedAt;


    /**
     * @throws Exception
     */
    public static function findOne(array $array): static|null
    {
        $tableName = static::tableName();
        $attributes = array_keys($array);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = Application::$app->database->pdo->prepare("SELECT id, first_name AS firstName, last_name AS lastName, email, password, created_at AS createdAt, updated_at AS updatedAt FROM $tableName WHERE $sql");
        foreach ($array as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        // Fetch the data as an associative array
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            // Convert createdAt to a DateTime object
            $data['createdAt'] = new DateTime($data['createdAt']);
            // Convert updatedAt to a DateTime object
            $data['updatedAt'] = new DateTime($data['updatedAt']);

            // Create and populate the User object
            $user = new static();
            $user->loadData($data);

            return $user;
        }

        return null;
    }


    public function validate(): bool|array
    {
        // clear errors
        $this->errors = [];
        // get the requirements
        $requirements = $this->getRequirements();
        foreach ($requirements as $field=>$rules){
            $fieldName = $field;
            foreach ($rules as $rule){
                $ruleName = $rule;
                $ruleValue = null;
                if(is_array($rule)) {
                    $ruleName = $rule[0];
                    $ruleValue = $rule['ruleValue'];
                }
                $this->validateByRule($ruleName, $fieldName, $this->{$fieldName}, $ruleValue);
            }
        }
        return $this->errors;
    }

    public function getRequirements(): array
    {
        return [
            'firstName' => [
                ValidationRule::required,
                [ValidationRule::min, 'ruleValue' => 3],
                [ValidationRule::max, 'ruleValue' => 60],
            ],
            'lastName' => [
                ValidationRule::required,
                [ValidationRule::min, 'ruleValue' => 3],
                [ValidationRule::max, 'ruleValue' => 60],
            ],
            'email' => [
                ValidationRule::required,
                ValidationRule::email,
                ValidationRule::unique,
            ],
            'password' => [
                ValidationRule::required,
                [ValidationRule::min, 'ruleValue' => 8],
                [ValidationRule::max, 'ruleValue' => 60],
            ],
            'confirmPassword' => [
                ValidationRule::required,
                [ValidationRule::match, 'ruleValue' => 'password'],
            ],
        ];
    }

    // save the user to the database
    public function save(): bool
    {
        $hashedPassword= password_hash($this->password, PASSWORD_DEFAULT);
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $sql = "INSERT INTO user (first_name, last_name, email, password, created_at, updated_at) 
                VALUES (:firstName, :lastName, :email, :password, :createdAt, :updatedAt)";
        $statement = Application::$app->database->pdo->prepare($sql);
        $statement->bindValue(':firstName', $this->firstName);
        $statement->bindValue(':lastName', $this->lastName);
        $statement->bindValue(':email', $this->email);
        $statement->bindValue(':password', $hashedPassword);
        $statement->bindValue(':createdAt', $this->createdAt->format('Y-m-d H:i:s'));
        $statement->bindValue(':updatedAt', $this->updatedAt->format('Y-m-d H:i:s'));
        return $statement->execute();
    }


    public static function tableName(): string
    {
        return 'user';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDisplayName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}