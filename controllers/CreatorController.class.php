<?php
include 'AdministratorController.class.php';

class CreatorController extends AdministratorController{

    public function __construct(){
        parent::__construct();
        if($_SESSION['permission'] < 4){
            header('Location: /');
        }
    }

    //Change background / name of the site... (those kind of actions ?)
    public function settings(){
        if($_SESSION['permission'] < 4){
            header('Location:/admin');
        }
        $v = new View('admin.settings','backend');
    }
}
