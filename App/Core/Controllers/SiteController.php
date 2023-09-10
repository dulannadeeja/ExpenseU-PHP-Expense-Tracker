<?php
declare(strict_types=1);

namespace App\Core\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthenticationMiddleware;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;

class SiteController extends Controller
{
    public function __construct(private readonly Request $request, private readonly Response $response)
    {
        $this->setLayout('main');
        $this->registerMiddleware(new AuthMiddleware(['index']));
        $this->registerMiddleware(new AuthenticationMiddleware(['index'],$this->request));
    }
    public function index()
    {
        $params = [
            'name' => $this->request->user
        ];
        return $this->render('home', $params);
    }
}