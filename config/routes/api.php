<?php

//method, uri, controller@action
return [
    ['GET', '/app/', [\App\Controllers\Http\AppController::class, 'index']],
];