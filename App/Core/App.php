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


        if ($_ENV['APP_DEBUG']) {
            $whoops = new Run;
            $handler = new PrettyPageHandler;
            
            $handler->blacklist('_ENV', 'DB_PASSWORD');
            $handler->blacklist('_ENV', 'DB_NAME');
            $handler->blacklist('_ENV', 'DB_USERNAME');
            $handler->blacklist('_ENV', 'DB_HOST');
            
            $handler->blacklist('_SERVER', 'DB_PASSWORD');
            $handler->blacklist('_SERVER', 'DB_NAME');
            $handler->blacklist('_SERVER', 'DB_USERNAME');
            $handler->blacklist('_SERVER', 'DB_HOST');
            $handler->blacklist('_SERVER', 'HTTP_COOKIE');

            $handler->setEditor('vscode');
            
            
            $whoops->pushHandler($handler);
            $whoops->register();
        }
    }
}
