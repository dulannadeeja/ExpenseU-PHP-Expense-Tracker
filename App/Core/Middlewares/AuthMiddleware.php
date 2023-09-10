<?php

namespace App\Core\Middlewares;

use App\Core\Application;
use App\Core\Exceptions\ForbiddenException;

class AuthMiddleware extends Middleware
{

    public function __construct(
        private readonly array $actions = []
    )
    {
    }

    /**
     * @throws ForbiddenException
     */
    public function execute(): void
    {
        if (Application::$app->auth->isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}