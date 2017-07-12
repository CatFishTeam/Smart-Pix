<?php
include 'ModeratorController.class.php';

class AdministratorController extends ModeratorController{
    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            header('Location:/login');
        }
        if($_SESSION['permission'] < 3){
            header('Location: /');
        }
    }

    public function test(){
        echo 'C\'est bon !';
    }

}
