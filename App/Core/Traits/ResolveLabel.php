<?php

namespace App\Core\Traits;

trait ResolveLabel
{
    public static function resolveLabel(string $attribute): string
    {
        return match ($attribute) {
            'username' => 'Username',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
            default => ''
        };
    }

}