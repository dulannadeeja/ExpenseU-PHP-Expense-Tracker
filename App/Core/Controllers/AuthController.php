<?php
declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Models\SigningUser;
use App\Core\Models\User;
use App\Core\Request;
use App\Core\Response;

class AuthController extends Controller
{
    public function __construct(private readonly Request $request, private readonly Response $response)
    {
        $this->setLayout('auth');
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function signUp(): bool|string
    {
        //instantiate the model
        $user = new User();
        if ($this->request->isPost()) {
            $user->loadData($this->request->getBody());
            if (!$user->validate() && $user->save()) {
                // redirect to home page
                Application::$app->response->redirect('/');
                exit;
            }
        }

        return $this->render('sign_up', ['model' => $user]);
    }

    public function signIn(): bool|string
    {
        // instantiate the model
        $signInUser = new SigningUser();
        if ($this->request->isPost()) {
            $signInUser->loadData($this->request->getBody());
            if (!$signInUser->validate() && $signInUser->login()) {
                // redirect to home page
                Application::$app->response->redirect('/');
                exit;
            }
        }
        return $this->render('sign_in', ['model' => $signInUser]);
    }

    public function signOut(): void
    {
        Application::$app->auth->logout();
        Application::$app->response->redirect('/');
        exit;
    }

}