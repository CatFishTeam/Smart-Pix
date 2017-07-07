<?php
session_start();
require 'conf.inc.php';

spl_autoload_register(function ($class) {
    if( file_exists('core/' . $class . '.class.php')){
        include 'core/' . $class . '.class.php';
    }elseif( file_exists('core/Router/'.$class.'.class.php')){
        include 'core/Router/' . $class . '.class.php';
    }elseif( file_exists('models/' . $class . '.class.php')){
        include 'models/' . $class . '.class.php';
    }
});


$router = new Router($_GET['url']);
//Les plus précises en premier
$router->get('/', function(){ echo 'Yolo'; });

$router->get('/posts', function(){ echo 'Yolo'; });

// $router->get('/posts/:id-:slug')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');

$router->get('/test/:id', "Index@test");

$router->run();
