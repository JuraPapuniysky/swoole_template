<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use \Nyholm\Psr7\Factory\Psr17Factory;
use PsrSwoole\ResponseMerger;
use PsrSwoole\Factory\NyholmRequestFactory as ServerRequestFactory;

$config = require __DIR__ . '/../config/config.php';

$container = new \DI\Container();
$router = new \App\Router\Router();
$uriFactory = new Psr17Factory();
$streamFactory = new Psr17Factory;
$responseFactory = new Psr17Factory;
$uploadedFileFactory = new Psr17Factory;
$responseMerger = new ResponseMerger;
$serverRequestFactory = new ServerRequestFactory();
$app = new \App\Application($config, $container, $router);


$server = new Swoole\HTTP\Server("127.0.0.1", 8080);

$server->on("start", function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:8080\n";
});

$server->on("request", function (Request $request, Response $response) use (
    $app,
    $uriFactory,
    $streamFactory,
    $responseFactory,
    $uploadedFileFactory,
    $responseMerger,
    $serverRequestFactory
) {

    $serverRequest = $serverRequestFactory->createRequest($request);

    $app->setRequest($serverRequest);

    $psrResponse = $app->run();

    $responseMerger->toSwoole($psrResponse, $response);
});

$server->start();