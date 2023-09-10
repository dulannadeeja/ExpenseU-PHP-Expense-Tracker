<?php
declare(strict_types=1);

namespace App\Core;

use App\Core\Middlewares\Middleware;

class Controller
{
    public string $action = '';
    public array $midllewares = [];

    public function setLayout(string $layout): void
    {
        Application::$app->view->setLayout($layout);
    }

    public function render(string $view, array $params = []): bool|string
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(Middleware $middleware): void
    {
        $this->midllewares[] = $middleware;
    }
}