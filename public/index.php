<?php

//requiring the autoload file, now every class with correct namespace will be auto loaded without using require
require_once __DIR__.'/../vendor/autoload.php';

//In composer.json, we use 'app' as namespace for project root directory
use app\controllers\AuthController;
use app\core\Application;
use app\controllers\SiteController;

//declaring Application class
$app = new Application(dirname(__DIR__)); //passing root dir name in Application construct

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();
