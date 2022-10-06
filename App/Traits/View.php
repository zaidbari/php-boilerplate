<?php

namespace App\Traits;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;


trait View
{

    protected function view( string $view, array $args = [] )
    {
        $loader = new FilesystemLoader([ 
            'resources/views/pages', 
            'resources/views/partials' 
        ]);
        $twig = new Environment($loader, [ 
            'cache' => $_ENV['APP_DEBUG'] ? false : 'cache/',
            'auto_reload' => true 
        ]);

        // GET FLASH MESSAGES
        $twig->addFunction(new TwigFunction('CLEAR', function () {
            unset($_SESSION['FLASH']); 
        }));

        $twig->addFunction(new TwigFunction('FLASH', fn() => $_SESSION['FLASH'] ?? false));
        $twig->addFunction(new TwigFunction('ENV', fn($data) => $_ENV[$data] ?? ''));

        $twig->addGlobal('USER', $_SESSION['user'] ?? false);

        echo $twig->render($view . '.twig', $args);
        exit();
    }
}
