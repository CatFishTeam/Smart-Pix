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

    /* ~~~~~ ADMINISTRATOR ~~~~ */
    public function profil(){
        if($_SESSION['permission'] < 3){
            header('Location:\admin');
        }
        $v = new View('admin.profil','backend');
        $v->assign("specificHeader","<script src=\"https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js\"></script>");
    }

    
    /* ~~~~~~ Users ~~~~~~ */
    public function users(){
        if($_SESSION['permission'] < 3){
            header('Location:/admin');
        }
        $v = new View('admin.users','backend');
        $users = new User();
        $users = $users->getAllBy();
        $v->assign('users',$users);

    }
    public function userPermission(){
        //For security purpose
        echo($_SESSION['permission']);
        if($_SESSION['permission'] < $_POST['permission']){
            //TODO RESPONSE VOUS N'AVEZ PAS LA PERMISSION DE FAIRE CECI
            echo 'test';
            exit();
        }
        $user = new User();
        $user = $user->populate(['id'=>$_POST['user_id']]);
        $user->setPermission($_POST['permission']);

        $now = new DateTime("now");
        $nowStr = $now->format("Y-m-d H:i:s");
        $user->setUpdatedAt($nowStr);

        $user->save();
        echo json_encode(array('date' => $nowStr));
        exit();
    }

    public function stats(){
        if($_SESSION['permission'] < 3){
            header('Location:/admin');
        }
        $v = new View('admin.stats','backend');
    }

}
