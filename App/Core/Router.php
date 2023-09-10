<?php

namespace App\Core;

use App\Core\Exceptions\NotFoundException;

class Router
{
    private array $routes = [];
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    // register a GET route
    public function get(string $path, array|string $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    // register a POST route
    public function post(string $path, array|string $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @throws NotFoundException
     */
    public function resolve(): bool|string
    {
        //get path and method
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        echo $path;
        echo $method;

        //get callback
        $callback = $this->routes[$method][$path] ?? false;

        //if callback is false, return not found
        if ($callback === false) {
            // set status code
            $this->response->setStatusCode(404);
            // throw not found exception
            throw new NotFoundException();
        }

        //if callback is string, render view
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        //if callback is array, call controller
        if (is_array($callback)) {
            // create new instance of controller
            $controller = new $callback[0]($this->request, $this->response);
            // set controller
            Application::$app->setController($controller);
            // set action
            Application::$app->controller->action = $callback[1];
            // call middleware
            foreach ($controller->midllewares as $middleware) {
                $middleware->execute();
            }
            // call controller action
            return Application::$app->controller->{$callback[1]}();
        }

        // return false if callback is not string or array
        return false;
    }

}