<?php

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
$router->post('/signup', 'Guest@signup');
$router->get('/activate/:id', 'User@activate');
$router->get('/forgetPassword', 'User@forgetPassword');
$router->get('/logout', 'User@logout');
$router->get('/user', 'Pages@wall');
$router->get('/user/:id', 'Pages@wall');
$router->get('/profile', 'User@index');

$router->get('admin' , 'Admin@index');
$router->get('/admin/albums' , 'Admin@albums');

$router->run();
