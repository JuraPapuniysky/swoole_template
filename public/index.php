<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use \Nyholm\Psr7\Factory\Psr17Factory;
use PsrSwoole\ResponseMerger;
use PsrSwoole\Factory\NyholmRequestFactory as ServerRequestFactory;
use App\Factories\ApplicationFactory;

$config = require __DIR__ . '/../config/config.php';

$uriFactory = new Psr17Factory();
$streamFactory = new Psr17Factory;
$responseFactory = new Psr17Factory;
$uploadedFileFactory = new Psr17Factory;
$responseMerger = new ResponseMerger;
$serverRequestFactory = new ServerRequestFactory();

$server = new Swoole\HTTP\Server($config['server']['host'], $config['server']['port']);

$server->on("start", function (Server $server) use ($config) {
    echo "Swoole http server is started at http://{$config['server']['host']}:{$config['server']['port']}\n";
});
$server->on("request", function (Request $request, Response $response) use (
    $config,
    $responseMerger,
    $serverRequestFactory
) {

    $serverRequest = $serverRequestFactory->createRequest($request);
    $app = ApplicationFactory::create($config);
    $app->setRequest($serverRequest);

    $psrResponse = $app->run();

    $response->setStatusCode($psrResponse->getStatusCode());

    $responseMerger->toSwoole($psrResponse, $response);
});

$server->start();
