<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\NotAllowedHttpException;
use App\Exceptions\NotFoundHttpException;
use App\Router\Router;
use DI\Container;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Application
{
    private array $config;

    private ?RequestInterface $request = null;

    private ?ResponseInterface $response = null;

    private Router $router;

    private Container $container;

    public function __construct(array $config, Container $container, Router $router)
    {
        $this->config = $config;
        $this->router = $router;
        $this->router->setRoutes($config['routes']);
        $this->container = $container;
    }

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
        $this->router->setRequest($request);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function run(): string
    {
        try {
            $handlerVars = $this->router->getHandlerVars();

            $responseModel = $this->container->call($handlerVars['handler'], $handlerVars['vars']);

            return $responseModel;
        } catch (NotFoundHttpException $e) {
            return $e->getMessage();
        } catch (NotAllowedHttpException $e) {
            return $e->getMessage();
        }
    }
}