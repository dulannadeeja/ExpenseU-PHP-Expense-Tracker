<?php

namespace App\Core;

use App\Core\Contracts\AuthInterface;
use App\Core\Contracts\UserInterface;
use App\Core\Models\User;

class Auth implements AuthInterface
{
    public function __construct()
    {
        $this->user = $this->getUser();
    }

    public ?UserInterface $user=null;
    public function getUser(): ?UserInterface
    {
        // check if the user is already logged in
        if($this->user){
            return $this->user;
        }

        // get the user from the session
        $primaryValue = Application::$app->session->get('user');
        if ($primaryValue) {
            $primaryKey = User::class::primaryKey();
            $this->user = User::class::findOne([$primaryKey => $primaryValue]);
        } else {
            return null;
        }
        return $this->user;
    }

    public function login(UserInterface $user): bool
    {
        // set the user in the session
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        Application::$app->session->set('user', $primaryValue);
        return true;
    }

    public function logout(): void
    {
        // unset the user from the session
        $this->user = null;
        Application::$app->session->remove('user');
    }

    public function isGuest(): bool
    {
        return !$this->user;
    }
}