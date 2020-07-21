<?php

//method, uri, controller@action
return [
    ['GET', '/app/{message}', [\App\Controllers\Http\AppController::class, 'index']],
];