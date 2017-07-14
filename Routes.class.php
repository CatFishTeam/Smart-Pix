<?php

$router = new Router($_GET['url']);

// $router->get('/posts', function(){ echo 'Yolo'; }); //Exemple avec function
// $router->get('/posts/:id-:slug')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+'); //Exemple avec multiple args
// //Les plus précises en premier

$router->get('/',                   'Pages@index');
$router->get('/test',               'Moderator@test');

$router->get('/album/:id',          'Pages@album');
$router->get('/picture/:id',        'Pages@picture');

$router->get('/login',              'Pages@login');
$router->post('/login',             'Pages@login');
$router->get('/signup',             'Pages@signup');
$router->post('/signup',            'Guest@signup');
$router->get('/activate/:token',    'Guest@activate');
$router->get('/forgetPassword',     'Guest@forgetPassword');
$router->post('/forgetPassword',    'Guest@forgetPassword');
$router->get('/user',               'Pages@wall');
$router->get('/user/:id',           'Pages@wall');
$router->get('/profile',            'User@index');
$router->post('/profile',            'User@index');

$router->get('/add-album',          'Album@create');
$router->post('/add-album',         'Album@create');
$router->get('/edit-album/',        'Album@edit');
$router->get('/edit-album/:id',     'Album@edit');
$router->post('/edit-album/:id',    'Album@edit');

$router->get('/add-picture',        'Picture@add');
$router->post('/add-picture',       'Picture@add');

$router->get('/add-comment',        'User@addComment');
$router->post('/add-comment',       'User@addComment');

$router->get('/logout',             'User@logout');

$router->get('/admin' ,             'Admin@index');
$router->get('/admin/albums' ,      'Admin@albums');

$router->run();
