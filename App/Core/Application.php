<?php
declare(strict_types=1);

namespace App\Core;

use App\Core\Exceptions\ForbiddenException;
use App\Core\Exceptions\NotFoundException;
use App\Core\Exceptions\SessionException;
use App\Core\Models\User;

class Application
{

    public static Application $app;
    public Router $router;
    public View $view;
    public Controller $controller;
    public Database $database;
    public Request $request;
    public Response $response;
    public Session $session;

    public Auth $auth;
    public static string $rootDir;

    /**
     * @throws SessionException
     */
    public function __construct(string $rootPath, array $config)
    {
        self::$app = $this;
        $this->database = new Database($config['db']);
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request,$this->response);
        $this->view = new View();
        $this->session = new Session();
        $this->session->start();
        $this->auth = new Auth();
        self::$rootDir = $rootPath;
    }

    public function run(): bool|string
    {
        try {
            return $this->router->resolve();
        }catch(NotFoundException $e){
            $this->response->setStatusCode($e->getCode());
            return $this->view->renderView('_error',[
                'exception' => $e
            ]);
        }catch (ForbiddenException $e){
            $this->response->setStatusCode($e->getCode());
            $this->response->redirect('/sign_in');
            return false;
        }

    }
    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

}