<?php

class CommunityController{
    public function checkName(){
        $name = $_POST['name'];
        $community = new Community;
        $community = $community->populate(['name' => $name]);
        // $user = $user->populate(array('username' => $_SESSION['username']));
        if($community){
            echo json_encode('error');
        } else {
            echo json_encode('good');
        }
    }

    public function index(){
        //TODO PK CA MARCHE PAS ?
        $v = new View('community.index', 'frontend');
        $communities = new Community;
        $communities->getAllBy(['user_id'=>$_SESSION['user_id']], "DESC");
        // echo '<pre>';
        // print_r($communities);
        $v->assign('communities', $communities);
    }

    public function create(){
            $community = new Community('DEFAULT', $_SESSION['user_id'], $_POST['name'], $_POST['description']);
            $now = new DateTime("now");
            $nowStr = $now->format("Y-m-d H:i:s");
            $community->setCreatedAt($nowStr);
            $community->setUpdatedAt($nowStr);
            $community->save(true);
            $_SESSION['messages']['success'][] = "Nouvelle communauté crée !";
            Header("Location: /community");
    }
}
