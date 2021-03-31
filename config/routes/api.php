<?php

//method, uri, [controller::class, action]
return [
    ['GET', '/app/count', [\App\Controllers\Http\AppController::class, 'count']],
    ['GET', '/app/{message}', [\App\Controllers\Http\AppController::class, 'index']],
    ['GET', '/app/set-index/{index}', [\App\Controllers\Http\AppController::class, 'setIndex']],
];
