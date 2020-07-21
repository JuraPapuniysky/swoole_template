<?php

declare(strict_types=1);

namespace App\Controllers\Http;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AppController extends Controller
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->response([
            'message' => 'Hello World',
        ], 200);
    }
}