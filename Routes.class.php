<?php

$router = new Router($_GET['url']);

// $router->get('/posts', function(){ echo 'Yolo'; }); //Exemple avec function
// $router->get('/posts/:id-:slug')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+'); //Exemple avec multiple args
// //Les plus précises en premier

$router->get('/',               'Pages@index');
$router->get('/test',           'Moderator@test');

$router->get('/album/:id',      'Pages@album');
$router->get('/picture/:id',    'Pages@picture');

$router->get('/login',          'Pages@login');
$router->post('/login',         'Pages@login');
$router->get('/signup',         'Pages@signup');
$router->post('/signup',        'Guest@signup');
$router->get('/activate/:id',   'Guest@activate');
$router->get('/forgetPassword', 'Guest@forgetPassword');
$router->get('/user', 'Pages@wall');
$router->get('/user/:id', 'Pages@wall');
$router->get('/profile', 'User@index');

$router->post('/add_comment',   'User@addComment');

$router->get('/logout',         'User@logout');
$router->get('/:id/wall',       'Pages@wall');

$router->get('/admin' ,         'Admin@index');
$router->get('/admin/albums' ,  'Admin@albums');

$router->run();
