<?php

class CommunityController{

    public function __construct(){
        
    }

    public function checkName(){
        $name = $_POST['name'];
        $community = new Community;
        $community = $community->populate(['name' => $name]);
        $user = new User;
        $user = $user->populate(array('username' => $_SESSION['username']));
        if($community){
            echo json_encode('error');
        } else {
            echo json_encode('good');
        }
    }

    public function index(){
        $v = new View('community.index', 'frontend');
        $communities = new Community;
        $communities = $communities->getAllBy(array('user_id'=>$_SESSION['user_id']), "DESC");
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
            Header("Location: /communities");
    }

    public function home($community = null) {
        if (!empty($community) && isset($_SESSION['user_id'])) {
            $userCommunity = new Community();
            $userCommunity = $userCommunity->populate(['slug' => $community]);
            if ($userCommunity) {
                $pictures = new Picture();
                $pictures = $pictures->getAllBy(['community_id' => $userCommunity->getId()], 'DESC');
                $v = new View('community.home', 'frontend');
                $v->assign('community', $userCommunity);
                $v->assign('pictures', $pictures);
            }
        } else {
            header("Location: /communities");
        }
    }

    public function wall($community = null, $id = null) {
        $commu = new Community();
        if (!empty($community)) {
            $commu = $commu->populate(['slug' => $community]);
        }
        $user = new User();
        if (empty($id) && !isset($_SESSION)) {
            $v = new View("community.home", "frontend");
            return 0;
        } elseif (empty($id) && isset($_SESSION['user_id'])) {
            $user = $user->populate(array('id' => $_SESSION['user_id']));
        } else {
            $user = $user->populate(array('id' => $id));
            var_dump($id);
            var_dump($user);
            if (empty($user)) {
//                header("Location: /");
                $v = new View("community.home", "frontend");
                return 0;
            }
        }
        $userId = $user->getId();
        $actions =  new Action();
        $actions = $actions->getAllBy(['user_id' => $userId, 'community_id' => $commu->getId()], 'DESC');
        $pictures = new Picture();
        $pictures = $pictures->getAllBy(['user_id' => $userId], 'DESC', 14);
        $albums = new Album();
        $albums = $albums->getAllBy(['user_id' => $userId], 'DESC', 14);

        $v = new View('community.wall', 'frontend');
        $v->assign('user', $user);
        $v->assign('actions', $actions);
        $v->assign('pictures', $pictures);
        $v->assign('albums', $albums);
        $v->assign('title', $user->getUsername());
    }
}
