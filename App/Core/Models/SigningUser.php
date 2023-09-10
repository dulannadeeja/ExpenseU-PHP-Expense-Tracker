<?php

namespace App\Core\Models;

use App\Core\Application;
use App\Core\Models\Enum\ValidationRule;
use Exception;

class SigningUser extends User
{
    public function getRequirements(): array
    {
        return [
            'email' => [
                ValidationRule::required,
                ValidationRule::email
            ],
            'password' => [
                ValidationRule::required,
                [ValidationRule::min, 'ruleValue' => 8],
                [ValidationRule::max, 'ruleValue' => 60]
            ]
        ];
    }

    /**
     * @throws Exception
     */
    public function login(): bool
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User with this email does not exist.');
            return false;
        }
        if (!(password_verify($this->password, $user->password))) {
            $this->addError('password', "Password is incorrect.");
            return false;
        }

        // login the user
        return Application::$app->auth->login($user);

    }

}