<?php
session_start();
require 'conf.inc.php';

// phpinfo();

spl_autoload_register(function ($class) {
    if( file_exists('core/' . $class . '.class.php')){
        include 'core/' . $class . '.class.php';
    }elseif( file_exists('core/Router/'.$class.'.class.php')){
        include 'core/Router/' . $class . '.class.php';
    }elseif( file_exists('models/' . $class . '.class.php')){
        include 'models/' . $class . '.class.php';
    }
});

// throw new Exception('test');


$router = new Router($_GET['url']);
// //Les plus précises en premier
$router->get('/', 'Pages@index');

$router->get('/posts', function(){ echo 'Yolo'; });

// $router->get('/posts/:id-:slug')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');

$router->get('/test/:id', "Index@test");

$router->get('/album/:id', 'Pages@album');

$router->get('/picture/:id', 'Pages@picture');

$router->get('/login',   'Pages@login');
$router->post('/login',  'Pages@login');
$router->get('/signup', 'Pages@signup');
$router->post('/signup', 'Pages@signup');
$router->get('/activate/:id', 'User@activate');
$router->get('/forgetPassword', 'User@forgetPassword');
$router->get('/logout', 'User@logout');

$router->get('/:id/wall', 'Pages@wall');


$router->get('admin' , 'Admin@index');
$router->get('/admin/albums' , 'Admin@albums');

$router->run();
