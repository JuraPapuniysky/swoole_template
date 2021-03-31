<?php

declare(strict_types=1);

namespace App\Controllers;

use Nyholm\Psr7\Factory\Psr17Factory;
use phputil\JSON;
use Psr\Http\Message\ResponseInterface;

class Controller
{
    protected function response($data, $code = 200): ResponseInterface
    {
        $responseFactory = new Psr17Factory();

        $response = $responseFactory->createResponse($code);
        $steam = $responseFactory->createStream(JSON::encode($data));
        $response = $response->withBody($steam);
        $response = $response->withStatus($code);

        return $response;
    }

    protected function middleware(string $class, array $options): void
    {

    }
}