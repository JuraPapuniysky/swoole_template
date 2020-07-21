<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;

class ErrorController extends Controller
{
    public function error(int $code, string $message): ResponseInterface
    {
        return $this->response($message, $code);
    }
}