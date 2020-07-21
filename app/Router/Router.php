<?php

declare(strict_types=1);

namespace App\Router;

use App\Controllers\ErrorController;
use App\Exceptions\NotAllowedHttpException;
use App\Exceptions\NotFoundHttpException;
use DI\Container;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher;

    private Container $container;

    public function setRoutes(array $routingConfig): void
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $router) use($routingConfig){
            foreach ($routingConfig as $route) {
                $router->addRoute($route[0], $route[1], $route[2]);
            }
        });
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $httpMethod = $request->getMethod();
        $uri = $request->getUri()->getPath();

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $code = 404;
                $message = 'Not found';

                return $this->container->call([ErrorController::class, 'error'], [$code, $message]);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $code = 403;
                $message = 'Method not allowed';

                return $this->container->call([ErrorController::class, 'error'], [$code, $message]);
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars['request'] = $request;
                foreach ($routeInfo[2] as $varName => $value) {
                    $vars[$varName] = $value;
                }

                return $this->container->call($handler, $vars);

                break;
        }
    }
}