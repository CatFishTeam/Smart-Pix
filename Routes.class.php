<?php

$router = new Router($_GET['url']);

// $router->get('/posts', function(){ echo 'Yolo'; }); //Exemple avec function
// $router->get('/posts/:id-:slug')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+'); //Exemple avec multiple args
// //Les plus précises en premier

$router->get('/',                       'Pages@index');
$router->get('/login',                  'Pages@login');
$router->get('/signup',                 'Pages@signup');
$router->get('/user',                   'Pages@wall');
$router->get('/user/:id',               'Pages@wall');
$router->get('/user-actions',           'User@actions');

$router->post('/login',                 'Guest@login');
$router->post('/signup',                'Guest@signup');
$router->get('/activate/:token',        'Guest@activate');
$router->get('/forgetPassword',         'Guest@forgetPassword');
$router->post('/forgetPassword',        'Guest@forgetPassword');

$router->get('/user-pictures',                  'User@pictures');
$router->get('/user-pictures/:id',              'User@pictures');
$router->get('/:community/user-pictures',        'Community@pictures')->with('community','communities');
$router->get('/:community/user-pictures/:id',    'Community@pictures')->with('community','communities')->with('id', '[0-9]+');
$router->get('/user-albums',                    'User@albums');
$router->get('/user-albums/:id',                'User@albums');
$router->get('/:community/user-albums',          'Community@albums')->with('community','communities');
$router->get('/:community/user-albums/:id',      'Community@albums')->with('community','communities')->with('id', '[0-9]+');
$router->get('/profile',                        'User@index');
$router->post('/profile',                       'User@index');
$router->get('/:community/profile',              'User@index')->with('community','communities');;
$router->post('/:community/profile',             'User@index')->with('community','communities');;
$router->post('/add-comment',                   'User@addComment');
//$router->get('/add-album',              'Album@create');
//$router->post('/add-album',             'Album@create');
//$router->get('/edit-album',             'Album@edit');
//$router->get('/edit-album/:id',         'Album@edit');
//$router->post('/edit-album/:id',        'Album@edit');
$router->post('/album/remove-picture',  'Album@removePicture');
$router->post('/album/add-pictures',    'Album@addPictures');

//$router->get('/add-picture',            'Picture@add');
//$router->post('/add-picture',           'Picture@add');



$router->get('/logout',                 'User@logout');

// $router->get('/admin',                  'Moderator@index');
// $router->post('/admin/addAlbum',        'Moderator@addAlbum');
// $router->post('/admin/getAlbum',        'Moderator@getAlbum');
// $router->post('/admin/editAlbum',       'Moderator@editAlbum');
// $router->post('/admin/deleteAlbum',     'Moderator@deleteAlbum');
//
// $router->post('/admin/mediaUpload',     'Moderator@mediaUpload');
//
// $router->get('/admin/comments',         'Moderator@comments');
// $router->get('/admin/albums',           'Moderator@showAlbums');
// $router->get('/admin/medias',           'Moderator@medias');
//
$router->post('/community/create',      'Community@create');
$router->get('/communities',            'Community@index');
$router->get('/community/create',       'User@createCommunity');
$router->post('/community/check-name',  'Community@checkName');


$router->get('/:community',                          'Community@home')->with('community','communities');
$router->get('/:community/album/:id',                'Community@album')->with('community','communities')->with('id', '[0-9]+');
$router->get('/:community/picture/:id',              'Community@picture')->with('community','communities')->with('id', '[0-9]+');
$router->get('/:community/add-album',                'Community@showAddAlbum')->with('community','communities');
$router->post('/:community/add-album',               'Community@addAlbum')->with('community','communities');
$router->get('/:community/edit-album',               'Community@showEditAlbum')->with('community','communities');
$router->get('/:community/edit-album/:id',           'Community@editAlbum')->with('community','communities')->with('id', '[0-9]+');
$router->post('/:community/edit-album/:id',          'Community@editAlbum')->with('community','communities')->with('id', '[0-9]+');
$router->post('/:community/album/remove-picture',    'Community@removePictureFromAlbum')->with('community','communities');
$router->post('/:community/album/add-pictures',      'Community@addPicturesToAlbum')->with('community','communities');
$router->get('/:community/add-picture',              'Community@showAddPicture')->with('community','communities');
$router->post('/:community/add-picture',             'Community@addPicture')->with('community','communities');
$router->get('/:community/user',                     'Community@wall')->with('community','communities');
$router->get('/:community/user/:id',                 'Community@wall')->with('community','communities')->with('id', '[0-9]+');

$router->get('/:communitiy/admin',                  'Moderator@indexAdmin')->with('community','communities');

$router->get('/:communitiy/admin/albums',           'Moderator@showAlbums')->with('community','communities');
$router->post('/:communitiy/admin/addAlbum',        'Moderator@addAlbum')->with('community','communities');
$router->post('/:communitiy/admin/getAlbum',        'Moderator@getAlbum')->with('community','communities');
$router->post('/:communitiy/admin/editAlbum',       'Moderator@editAlbum')->with('community','communities');
$router->post('/:communitiy/admin/deleteAlbum',     'Moderator@deleteAlbum')->with('community','communities');

$router->get('/:communitiy/admin/medias',           'Moderator@medias')->with('community','communities');
$router->post('/:communitiy/admin/uploadMedia',     'Moderator@uploadMedia')->with('community','communities');
$router->post('/:communitiy/admin/deleteMedia',     'Moderator@deleteMedia')->with('community','communities');

$router->get('/:communitiy/admin/comments',         'Moderator@comments')->with('community','communities');
$router->post('/:communitiy/admin/publishComment',  'Moderator@publishComment')->with('community','communities');
$router->post('/:communitiy/admin/unpublishComment','Moderator@unpublishComment')->with('community','communities');
$router->post('/:communitiy/admin/deleteComment',   'Moderator@deleteComment')->with('community','communities');


$router->run();
