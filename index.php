<?php

session_start();

// autoloader
use App\Core\App;
use Bramus\Router\Router;

require __DIR__ . '/vendor/autoload.php';

App::run(__DIR__);

// create a new router
$router = new Router();
$router->setNamespace('\App\Controllers');


/**
 * =========================
 * Public routes
 * =========================
 **/
$router->get('/', 'Guest@index');


/**
 * =========================
 * Authentication routes
 * =========================
 **/
$router->get('/login', 'Auth@loginView');
$router->get('/signup', 'Auth@signupView');
$router->get('/logout', 'Auth@logout');
$router->post('/user/create', 'Auth@create');
$router->post('/user/login', 'Auth@login');


/**
 * =========================
 * Private routes
 * =========================
 **/
$router->get('/dashboard', 'Dashboard@index');


$router->run();
