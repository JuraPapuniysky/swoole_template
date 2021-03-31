<?php

declare(strict_types=1);

namespace App\Controllers\Http;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AppController extends Controller
{
    private int $indexActionCount = 0;

    public function index(ServerRequestInterface $request, string $message): ResponseInterface
    {
        return $this->response([
            'message' => $message,
        ], 200);
    }

    public function count(ServerRequestInterface $request): ResponseInterface
    {
        $this->indexActionCount++;

        return $this->response([
            'message' => $this->indexActionCount,
        ]);
    }

    public function setIndex(ServerRequestInterface $request, string $index): ResponseInterface
    {
        $this->indexActionCount = (int)$index;

        return $this->response([
            'message' => 'Success',
            'index' => $this->indexActionCount,
        ]);
    }
}
