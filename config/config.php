<?php

$apiRoutes = require __DIR__ . '/routes/api.php';
$server = require __DIR__ . '/server.php';
return [
    'server' => $server,
    'routes' => $apiRoutes,
];
