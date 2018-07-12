<?php

ini_set('display_errors', E_ALL);
error_reporting(1);
date_default_timezone_set('Europe/Kiev');
use Core\Router;
use Core\Db;

define('ROOT', __DIR__ .'/');
session_start();

//print_r([$_SESSION, $_SERVER]);die();
if((empty($_SESSION['login'])) and (!in_array($_SERVER['REQUEST_URI'], ['/','/login'])) ){
    header("Location: /");
    exit;
}/**/
require_once ROOT . '/vendor/autoload.php';
require_once 'config/routes.php';

\Controllers\MainController::rememberMe();

$router = new Router;
$router->addRoute($routes);
$router->dispatch();
