<?php

namespace App\Core;
use Dotenv\Dotenv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class App
{

    public static function run($dir)
    {
        // DotEnv File handler
        $dotenv = Dotenv::createImmutable($dir . "/");
        $dotenv->load();

        if ($_ENV['APP_DEBUG'] == true) {
            $whoops = new Run;
            $whoops->pushHandler(new PrettyPageHandler);
            $whoops->register();
        }
    }
}
