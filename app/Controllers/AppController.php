<?php

declare(strict_types=1);

namespace App\Controllers;

use phputil\JSON;
use Psr\Http\Message\RequestInterface;

class AppController
{
    public function index(RequestInterface $request): string
    {
        return JSON::encode($request);
    }
}