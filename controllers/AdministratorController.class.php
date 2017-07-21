<?php
include 'ModeratorController.class.php';

class AdministratorController extends ModeratorController{
    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            header('Location:/login');
        }
        if($_SESSION['permission'] < 3){
            $_SESSION['messages']['error'][] = "Vous n'avez pas la permission de faire ceci";
            header('Location:/'.$_SESSION['community_slug']);
        }
    }

    /* ~~~~~~ Users ~~~~~~ */
    public function users(){
        $v = new View('admin.users','backend');
        $users = [];
        $users_id = new Community_User;
        $users_id = $users_id->getAllBy(['community_id'=>$_SESSION['community_id']]);
        foreach($users_id as $user){
            $u = new User();
            $u = $u->getOneBy(['id'=>$user['user_id']]);
            $u['permission'] = $user['permission'];
            array_push($users, $u);
        }
        $v->assign('users',$users);

    }

    //TODO WTTTFFFFFFF ???
    public function userPermission(){
        if($_SESSION['permission'] < $_POST['permission']){
            $_SESSION['messages']['error'][] = "Vous n'avez pas la permission de faire ceci";
            GlobalController::flash('json');
            exit();
        }
        $user = new Community_User;
        $user = $user->populate(['user_id'=>$_POST['user_id']]);
        echo ('<pre>');
        var_dump($user);
        $user->setPermission($_POST['permission']);
        var_dump($user);
        $user->save();


        $now = new DateTime("now");
        $nowStr = $now->format("Y-m-d H:i:s");

        echo json_encode(array('date' => $nowStr));
        exit();
    }

}
