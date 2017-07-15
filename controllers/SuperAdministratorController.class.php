<?php
include 'AdministratorController.class.php';

class SuperAdministratorController extends AdministratorController{

    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            header('Location:/login');
        }
        if($_SESSION['permission'] < 4){
            header('Location: /');
        }
    }

    /* ~~~~ SUPER ADMINISTRATOR ~~~~~~ */
    //Change background / name of the site... (those kind of actions ?)
    public function settings(){
        if($_SESSION['permission'] < 4){
            header('Location:/admin');
        }
        $v = new View('admin.settings','backend');
    }
}
