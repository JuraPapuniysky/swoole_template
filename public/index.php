<?php

require_once __DIR__. '/../vendor/autoload.php';

use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

$config = require __DIR__ . '/../config/config.php';

$container = new \DI\Container();
$router = new \App\Router\Router();
$app = new \App\Application($config, $container, $router);


$server = new Swoole\HTTP\Server("127.0.0.1", 8080);

$server->on("start", function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:8080\n";
});

$server->on("request", function (Request $request, Response $response) use ($app) {
    $psrRequest = new \App\Request\Swoole\SwooleAdapterRequest($request);

    $app->setRequest($psrRequest);

    $responseData = $app->run();

    $response->header("Content-Type", "application/json");
    $response->end($responseData);
});

$server->start();