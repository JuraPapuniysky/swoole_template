<?php

declare(strict_types=1);

namespace App\Router;

use App\Exceptions\NotAllowedHttpException;
use App\Exceptions\NotFoundHttpException;
use DI\Container;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Http\Message\RequestInterface;
use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher;

    private RequestInterface $request;

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    public function setRoutes(array $routingConfig): void
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $router) use($routingConfig){
            foreach ($routingConfig as $route) {
                $router->addRoute($route[0], $route[1], $route[2]);
            }
        });
    }

    public function getHandlerVars(): array
    {
        $httpMethod = $this->request->getMethod();
        $uri = $this->request->getUri()->getHost() . $this->request->getUri()->getPath();

        var_dump($uri, $httpMethod);

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new NotFoundHttpException('Not found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new NotAllowedHttpException('Method not allowed');
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars['request'] = $this->request;
                foreach ($routeInfo[2] as $varName => $value) {
                    $vars[$varName] = $value;
                }

                return [
                    'handler' => $handler,
                    'vars' => $vars,
                ];

                break;
        }
    }
}