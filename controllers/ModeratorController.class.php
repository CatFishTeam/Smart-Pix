<?php
include 'UserController.class.php';

class ModeratorController extends UserController{
    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            $_SESSION['messages']['warning'][] = "Seuls les administrateurs ont accès a cette partie du site !";
            header('Location:/login');
        }
        if($_SESSION['permission'] < 2){
            echo $_SESSION['permission'];
            header('Location: /');
        }
    }

    public function test(){
        echo 'yolo';
    }
}
