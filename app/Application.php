<?php

declare(strict_types=1);

namespace App;

use App\Router\Router;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application
{
    private array $config;

    private ServerRequestInterface $request;

    private ?ResponseInterface $response = null;

    private Router $router;

    private Container $container;

    public function __construct(array $config, Container $container, Router $router)
    {
        $this->config = $config;
        $this->router = $router;
        $this->router->setRoutes($config['routes']);
        $this->router->setContainer($container);
        $this->container = $container;
    }

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    public function run(): ResponseInterface
    {
        return $this->router->handle($this->request);
    }
}