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

include 'Routes.class.php';

if(isset($_SESSION['messages'])){
    $flash = '<div class="flash-container">';
    foreach ($_SESSION['messages'] as $key => $messages) {
        $flash .= '<div class="flash flash-'.$key.'">';
        foreach ($messages as $message) {
            $flash .= '<div class="flash-cell">'.$message.'</div>';
        }
        $flash .= '</div>';
    }
    $flash .= '</div>';
    echo $flash;
    unset($_SESSION['messages']);
}
echo '<script>flash();</script>';
