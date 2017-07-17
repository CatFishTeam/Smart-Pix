<?php
session_start();
require 'conf.inc.php';
include 'controllers/GlobalController.class.php';

spl_autoload_register(function ($class) {
    if( file_exists('core/' . $class . '.class.php')){
        include 'core/' . $class . '.class.php';
    }elseif( file_exists('core/Router/'.$class.'.class.php')){
        include 'core/Router/' . $class . '.class.php';
    }elseif( file_exists('models/' . $class . '.class.php')){
        include 'models/' . $class . '.class.php';
    }
});

include 'Routes.class.php';

//TODO ? Placer ca dans la vue pour que les message s'affiche dans le cas où l'on utilise header
GlobalController::flash();
