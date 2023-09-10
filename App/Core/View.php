<?php
declare(strict_types=1);

namespace App\Core;

class View
{
    private string $layout = 'main';
    private string $title = 'example title';
    private array $stylesheets=[];

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }
    public function renderView(string $view, array $params = []): bool|string
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    private function renderOnlyView(string $view, array $params): bool|string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start(); // start buffering
        require_once Application::$rootDir . "/core/views/$view.php";
        return ob_get_clean(); // end buffering and return it
    }

    private function layoutContent(): bool|string
    {
        ob_start(); // start buffering
        require_once Application::$rootDir . "/core/views/layouts/$this->layout.php";
        return ob_get_clean(); // end buffering and return it
    }

}