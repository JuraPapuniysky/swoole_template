<?php

declare(strict_types=1);

namespace App\Factories;

use App\Application;

class ApplicationFactory
{
    private static ?Application $application;

    public static function create(array $config): Application
    {
        if (empty(self::$application)) {
            $container = new \DI\Container();
            $router = new \App\Router\Router();
            self::$application = new Application($config, $container, $router);
        }

        return self::$application;
    }
}
