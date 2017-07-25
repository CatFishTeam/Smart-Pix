<?php

$router = new Router($_GET['url']);

// $router->get('/posts', function(){ echo 'Yolo'; }); //Exemple avec function
// $router->get('/posts/:id-:slug')->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+'); //Exemple avec multiple args
// //Les plus précises en premier

$router->get('/',                       'Pages@index');
$router->get('/404',                    'Pages@error');

$router->get('/login',                  'Pages@login');
$router->get('/signup',                 'Pages@signup');
$router->get('/user',                   'Pages@wall');
$router->get('/user/:id',               'Pages@wall')->with('id', '[0-9]+');
$router->get('/user-actions',           'User@actions');
$router->get('/search',                'Pages@search');
$router->post('/search',                'Pages@search');

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
$router->post('/picture/remove-tag',    'Picture@removeTag');
$router->post('/album/remove-picture',  'Album@removePicture');
$router->post('/album/add-pictures',    'Album@addPictures');

$router->get('/logout',                 'User@logout');

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
$router->get('/:community/edit-album/:id',           'Community@showEditAlbum')->with('community','communities')->with('id', '[0-9]+');
$router->post('/:community/edit-album/:id',          'Community@editAlbum')->with('community','communities')->with('id', '[0-9]+');
$router->post('/:community/album/remove-picture',    'Community@removePictureFromAlbum')->with('community','communities');
$router->post('/:community/album/add-pictures',      'Community@addPicturesToAlbum')->with('community','communities');
$router->get('/:community/add-picture',              'Community@showAddPicture')->with('community','communities');
$router->post('/:community/add-picture',             'Community@addPicture')->with('community','communities');
$router->get('/:community/edit-picture/:id',         'Community@showEditPicture')->with('community', 'communities')->with('id', '[0-9]+');
$router->post('/:community/edit-picture/:id',        'Community@editPicture')->with('community', 'communities')->with('id', '[0-9]+');
$router->get('/:community/user',                     'Community@wall')->with('community','communities');
$router->get('/:community/user/:id',                 'Community@wall')->with('community','communities')->with('id', '[0-9]+');
$router->get('/:community/join',                     'Community@join')->with('community','communities');
$router->get('/:community/tag/:id/:tag',             'Picture@tag')->with('community', 'communities')->with('id', '[0-9]+')->with('tag', '[\w\-]+');
$router->post('/:community/media/loadMore',          'Guest@loadMore')->with('community', 'communities');

$router->get(':community/feed',                      'Guest@feed')->with('community','communities')->with('id', '[0-9]+');
$router->get(':community/user/:id/feed',             'Guest@feedUser')->with('community','communities')->with('id', '[0-9]+');

$router->get('/:communitiy/admin',                  'Moderator@indexAdmin')->with('community','communities');

$router->get('/:communitiy/admin/albums',                      'Moderator@showAlbums')->with('community','communities');
$router->post('/:communitiy/admin/addAlbum',                   'Moderator@addAlbum')->with('community','communities');
$router->post('/:communitiy/admin/getAlbum',                   'Moderator@getAlbum')->with('community','communities');
$router->post('/:communitiy/admin/editAlbum',                  'Moderator@editAlbum')->with('community','communities');
$router->post('/:communitiy/admin/deleteAlbum',                'Moderator@deleteAlbum')->with('community','communities');
$router->post('/:communitiy/admin/addPictureToAlbum',          'Moderator@addPictureToAlbum')->with('community','communities');
$router->post('/:communitiy/admin/removePictureFromAlbum',     'Moderator@removePictureFromAlbum')->with('community','communities');
$router->post('/:communitiy/admin/setPictureAsCover',          'Moderator@setPictureAsCover')->with('community','communities');

$router->get('/:communitiy/admin/medias',           'Moderator@medias')->with('community','communities');
$router->post('/:communitiy/admin/uploadMedia',     'Moderator@uploadMedia')->with('community','communities');
$router->post('/:communitiy/admin/deleteMedia',     'Moderator@deleteMedia')->with('community','communities');
$router->post('/:communitiy/admin/unPublishMedia',  'Moderator@unPublishMedia')->with('community','communities');
$router->post('/:communitiy/admin/publishMedia',    'Moderator@publishMedia')->with('community','communities');

$router->get('/:communitiy/admin/comments',         'Moderator@comments')->with('community','communities');
$router->post('/:communitiy/admin/publishComment',  'Moderator@publishComment')->with('community','communities');
$router->post('/:communitiy/admin/unpublishComment','Moderator@unpublishComment')->with('community','communities');
$router->post('/:communitiy/admin/deleteComment',   'Moderator@deleteComment')->with('community','communities');

$router->get('/:communitiy/admin/users',            'Administrator@users')->with('community','communities');
$router->post('/:communitiy/admin/userPermission',  'Administrator@userPermission')->with('community','communities');

$router->get('/:communitiy/admin/settings',        'Creator@settings')->with('community','communities');


$router->run();
