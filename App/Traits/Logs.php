<?php

namespace App\Traits;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

trait Logs
{
    public static function log( $type, string $message, array $data = [] )
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/logs/' . $type . '.log';

        $stream = new StreamHandler($path, $type, true, 0777);
        $firephp = new FirePHPHandler();

        $dateFormat = "d-M-Y, g:i a";

        /** 
         * "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
         */
        $output = "%datetime% > %message% %context% %extra%\n";

        // finally, create a formatter
        $formatter = new LineFormatter($output, $dateFormat);
        $stream->setFormatter($formatter);

        // Create the main logger of the app
        $logger = new Logger($type);
        $logger->pushHandler($stream);
        $logger->pushHandler($firephp);

        // Log the message
        $logger->$type($message, $data);
    }
}
