<?php

namespace App\Core\Models\Traits;

use App\Core\Application;
use App\Core\Models\Enum\ValidationRule;
use App\Core\Traits\ResolveLabel;

trait Validation
{

    use ResolveLabel;

    protected array $errors = [];

    public function validateRequired($fieldName, $label, $value): void
    {
        if (empty($value)) {
            $this->addError($fieldName, "$label is required.");
        }
    }

    public function validateEmail($fieldName, $label, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($fieldName, "$label must be a valid email address.");
        }
    }

    public function validateMinLength($fieldName, $label, $value, $minLength): void
    {
        if (strlen($value) < $minLength) {
            $this->addError($fieldName, "$label must be at least $minLength characters long.");
        }
    }

    public function validateMaxLength($fieldName, $label, $value, $maxLength): void
    {
        if (strlen($value) > $maxLength) {
            $this->addError($fieldName, "$label must be no more than $maxLength characters long.");
        }
    }

    public function validateMatch($fieldName, $label, $value, $matchField): void
    {
        if ($value !== $this->{$matchField}) {
            $matchFieldLabel = $this->resolveLabel($matchField);
            $this->addError($fieldName, "$label does not match $matchFieldLabel.");
        }
    }

    public function validateUnique($fieldName, $label, $value): void
    {
        $tableName = static::tableName();
        $statement = Application::$app->database->pdo->prepare("SELECT * FROM $tableName WHERE $fieldName = :$fieldName");
        $statement->bindValue(":$fieldName", $value);
        $statement->execute();
        $record = $statement->fetchObject(static::class);
        if ($record) {
            $this->addError($fieldName, "This $label already exists.");
        }
    }

    // Validate based on rule name and optional ruleValue
    public function validateByRule($rule, $fieldName, $value, $ruleValue = null): void
    {
        $label = $this->resolveLabel($fieldName);
        switch ($rule) {
            case ValidationRule::required:
                $this->validateRequired($fieldName, $label, $value);
                break;
            case ValidationRule::email:
                $this->validateEmail($fieldName, $label, $value);
                break;
            case ValidationRule::min:
                $this->validateMinLength($fieldName, $label, $value, $ruleValue);
                break;
            case ValidationRule::max:
                $this->validateMaxLength($fieldName, $label, $value, $ruleValue);
                break;
            case ValidationRule::match:
                $this->validateMatch($fieldName, $label, $value, $ruleValue);
                break;
            case ValidationRule::unique:
                $this->validateUnique($fieldName, $label, $value);
                break;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function addError($field, $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function hasError($field): bool
    {
        if(isset($this->errors[$field])){
            return true;
        }else{
            return false;
        }
    }

    public function getFirstError($field): string
    {
        return $this->errors[$field][0] ?? '';
    }
}