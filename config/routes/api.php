<?php

//method, uri, [controller::class, action]
return [
    ['GET', '/app/{message}', [\App\Controllers\Http\AppController::class, 'index']],
];