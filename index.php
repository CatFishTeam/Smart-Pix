<?php
session_start();
require 'conf.inc.php';


spl_autoload_register(function ($class) {
    if( file_exists('core/' . $class . '.class.php')){
        include 'core/' . $class . '.class.php';
    }elseif( file_exists('models/' . $class . '.class.php')){
        include 'models/' . $class . '.class.php';
    }
});


$routing = new Routing();
