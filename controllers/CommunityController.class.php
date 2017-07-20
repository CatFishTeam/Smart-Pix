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
            $_SESSION['messages']['success'][] = "Nouvelle communauté créée !";
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
            if (!$commu) {
                $_SESSION['messages']['error'][] = "La communauté n'a pas été trouvée";
                $v = new View("community.home", "frontend");
                return 0;
            }
        }
        $user = new User();
        if (empty($id) && !isset($_SESSION)) {
            $v = new View("community.home", "frontend");
            return 0;
        } elseif (empty($id) && isset($_SESSION['user_id'])) {
            $user = $user->populate(array('id' => $_SESSION['user_id']));
        } else {
            $user = $user->populate(array('id' => $id));
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
        $v->assign('community', $commu);
        $v->assign('user', $user);
        $v->assign('actions', $actions);
        $v->assign('pictures', $pictures);
        $v->assign('albums', $albums);
        $v->assign('title', $user->getUsername());
    }

    public function showAddAlbum() {

    }

    public function addAlbum() {

    }

    public function showAddPicture() {
        $v = new View("picture.create", "frontend");
        $v->assign('title', "Ajout d'une image");
    }

    public function addPicture($community = null) {
        if (!empty($community)) {
            $commu = new Community();
            $commu = $commu->populate(['slug' => $community]);
            if (!$commu) {
                $_SESSION['messages']['error'][] = "La communauté n'a pas été trouvée";
                $v = new View("community.home", "frontend");
                return 0;
            }
        }
        if ($_POST && isset($commu)) {
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $picture = new Picture();

            if (!empty($title) && !empty($description)) {
                $picture->setUserId($_SESSION['user_id']);
                $picture->setAlbumId(null);
                $picture->setTitle($title);
                $picture->setDescription($description);
                $picture->setCommunityId($commu->getId());
                if (isset($_FILES["picture"])) {
                    if ($_FILES['picture']['error'] > 0) {
                        if ($_FILES['picture']['error'] == 1 || $_FILES['picture']['error'] == 2)
                            $_SESSION['messages']['warning'][] = "Le fichier d'image est trop volumineux (max: 5 Mo)";
                        elseif ($_FILES['picture']['error'] != 4)
                            $_SESSION['messages']['warning'][] = "Le fichier d'image a rencontré une erreur.";
                    } else {
                        $fileInfo = pathinfo($_FILES['picture']['name']);
                        $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                        if (
                            strtolower($fileInfo["extension"]) == "jpg" ||
                            strtolower($fileInfo["extension"]) == "jpeg" ||
                            strtolower($fileInfo["extension"]) == "png" ||
                            strtolower($fileInfo["extension"]) == "gif"
                        ) {
                            $now = new DateTime("now");
                            $nowStr = $now->format("Y-m-d H:i:s");
                            $picture->setUrl($ext);
                            $picture->setWeight($_FILES['picture']['size']);
                            $picture->setIsVisible(0);
                            $picture->setIsArchived(0);
                            $picture->setCreatedAt($nowStr);
                            $picture->setUpdatedAt($nowStr);
                            $picture->save();
                            // Create related action
                            $action = new Action();
                            $action->setUserId($_SESSION['user_id']);
                            $action->setCommunityId($commu->getId());
                            $action->setTypeAction("picture");
                            $action->setRelatedId($picture->getDb()->lastInsertId());
                            $action->setCreatedAt($nowStr);
                            $action->save();
                            move_uploaded_file($_FILES['picture']['tmp_name'], "./public/cdn/images/".$picture->getUrl());
                            header("Location: /".$commu->getSlug()."/picture/".$picture->getDb()->lastInsertId());
                            $_SESSION['messages']['success'][] = "Votre image a été ajoutée";
                        } else {
                            $_SESSION['messages']['warning'][] = "Format d'image invalide<br>(essayez: .jpg, .jpeg, .png ou .gif)";
                        }
                    }
                } else {
                    $_SESSION['messages']['warning'][] = "Aucune image sélectionnée";
                }
            }

        }
    }
}
