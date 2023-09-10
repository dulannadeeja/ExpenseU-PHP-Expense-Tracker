<?php

namespace App\Core\Middlewares;

use App\Core\Application;
use App\Core\Auth;
use App\Core\Models\User;
use App\Core\Request;

class AuthenticationMiddleware extends Middleware
{
    public function __construct(
        private readonly array   $actions = [],
        private readonly Request $request,
    )
    {
    }

    public function execute(): void
    {
        if(empty($this->actions) || in_array(Application::$app->controller->action,$this->actions)){
            // pass the user along with the request
            $this->request->user = Application::$app->auth->getUser();
        }
    }
}