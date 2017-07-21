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

    public function checkCommunity($community) {
        if (!empty($community)) {
            $commu = new Community();
            $commu = $commu->populate(['slug' => $community]);
            if (!$commu) {
                $_SESSION['messages']['error'][] = "La communauté n'a pas été trouvée";
                $v = new View("404", "frontend");
                return 0;
            }
            return $commu;
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
            header("Location: /communities");
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
                $v = new View("404", "frontend");
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
                $_SESSION['messages']['error'][] = "L'utilisateur n'a pas été trouvé";
                $v = new View("404", "frontend");
                return 0;
            }
        }
        $userId = $user->getId();
        $actions =  new Action();
        $actions = $actions->getAllBy(['user_id' => $userId, 'community_id' => $commu->getId()], 'DESC');
        $pictures = new Picture();
        $pictures = $pictures->getAllBy(['user_id' => $userId, 'community_id' => $commu->getId()], 'DESC', 14);
        $albums = new Album();
        $albums = $albums->getAllBy(['user_id' => $userId, 'community_id' => $commu->getId()], 'DESC', 14);

        $v = new View('community.wall', 'frontend');
        $v->assign('community', $commu);
        $v->assign('user', $user);
        $v->assign('actions', $actions);
        $v->assign('pictures', $pictures);
        $v->assign('albums', $albums);
        $v->assign('title', $user->getUsername());
    }

    public function showAddAlbum($community = null) {
        $v = new View("album.create", "frontend");
        $v->assign('title', "Ajout d'un album");
        $commu = $this->checkCommunity($community);
        $v->assign('community', $commu);
    }

    public function addAlbum($community = null) {
        $commu = $this->checkCommunity($community);
        if ($_POST) {
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $album = new Album();

            if (!empty($title) && !empty($description)) {
                $now = new DateTime("now");
                $nowStr = $now->format("Y/m/d H:i:s");
                $album->setUserId($_SESSION['user_id']);
                $album->setTitle($title);
                $album->setDescription($description);
                $album->setCommunityId($commu->getId());
                if (isset($_FILES["thumbnail_url"])) {
                    if ($_FILES['thumbnail_url']['error'] > 0) {
                        if ($_FILES['thumbnail_url']['error'] == 1 || $_FILES['thumbnail_url']['error'] == 2)
                            $_SESSION['messages']['warning'][] = "Le fichier d'image est trop volumineux (max: 5 Mo)";
                        elseif ($_FILES['thumbnail_url']['error'] != 4)
                            $_SESSION['messages']['warning'][] = "Le fichier d'image a rencontré une erreur.";
                    } else {
                        var_dump("test");
                        $fileInfo = pathinfo($_FILES['thumbnail_url']['name']);
                        $ext = pathinfo($_FILES['thumbnail_url']['name'], PATHINFO_EXTENSION);
                        if (
                            strtolower($fileInfo["extension"]) == "jpg" ||
                            strtolower($fileInfo["extension"]) == "jpeg" ||
                            strtolower($fileInfo["extension"]) == "png" ||
                            strtolower($fileInfo["extension"]) == "gif"
                        ) {
                            $album->setThumbnailUrl($ext);
                            move_uploaded_file($_FILES['thumbnail_url']['tmp_name'], "./public/cdn/images/" . $album->getThumbnailUrl());

                            $_SESSION['messages']['success'][] = "L'image de couverture a été ajoutée";
                        } else {
                            $_SESSION['messages']['warning'][] = "Format d'image invalide<br>(essayez: .jpg, .jpeg, .png ou .gif)";
                        }
                    }
                }
                $album->setBackground(null);
                $album->setDisposition(null);
                $album->setIsPresentation(0);
                $album->setIsPublished(1);
                $album->setCreatedAt($nowStr);
                $album->setUpdatedAt($nowStr);
                $album->save();
                // Create related action
                $action = new Action();
                $action->setUserId($_SESSION['user_id']);
                $action->setCommunityId($commu->getId());
                $action->setTypeAction("album");
                $action->setRelatedId($album->getDb()->lastInsertId());
                $action->setCreatedAt($nowStr);
                $action->save();
                header("Location: /".$commu->getSlug()."/album/".$album->getDb()->lastInsertId());
                $_SESSION['messages']['success'][] = "Votre album a été créé";
            } else {
                $_SESSION['messages']['warning'][] = "La création de l'album a échoué";
            }
        }
    }

    public function showAddPicture($community = null) {
        $v = new View("picture.create", "frontend");
        $v->assign('title', "Ajout d'une image");
        $commu = $this->checkCommunity($community);
        $v->assign('community', $commu);
    }

    public function addPicture($community = null) {
        $commu = $this->checkCommunity($community);
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

    public function picture($community = null, $id = null) {
        $v = new View('picture.index', 'frontend');
        $v->assign('id', $id);
        $commu = $this->checkCommunity($community);
        $v->assign('community', $commu);

        if (empty($id)) {
            // Listing des images
            $allPictures = new Picture();
            $allPictures = $allPictures->getAllBy([], 'DESC');
            $v->assign('allPictures', $allPictures);
        } else {
            // Affichage d'une image avec $id
            $picture = new Picture();
            $picture = $picture->populate(['id' => $id, 'community_id' => $commu->getId()]);
            if (!empty($picture)) {
                $author = new User();
                $author = $author->populate(['id' => $picture->getUserId()]);
                $v->assign('author', $author);
                $v->assign('title', $picture->getTitle());
            }
            $v->assign('picture', $picture);

            $albumsId = new Picture_Album();
            $albumsId = $albumsId->getAllBy(['picture_id' => $id]);

            $albums = array();
            foreach ($albumsId as $albumId) {
                $album = new Album();
                $album = $album->getOneBy(['id' => $albumId['album_id']]);
                array_push($albums, $album);
            }
            $v->assign('albums', $albums);

            $comments = new Comment();
            $comments = $comments->getAllBy(['picture_id'=>$id[0],'is_archived'=>0, 'is_published'=>1], 'DESC');
            $v->assign('comments', $comments);
            if(isset($_SESSION['user_id'])){
                $unpublishedComments = new Comment();
                $unpublishedComments = $unpublishedComments->getAllBy(['picture_id'=>$id[0], 'user_id'=>$_SESSION['user_id'], 'is_archived'=>0, 'is_published'=>0]);
                if(count($unpublishedComments) > 0){
                    $v->assign('unpublishedComments', count($unpublishedComments));
                }
            }

        }
    }

    public function pictures($community = null, $id = null) {
        $v = new View('user.pictures', 'frontend');
        $commu = $this->checkCommunity($community);
        $v->assign('community', $commu);
        if (!empty($id) || isset($_SESSION['user_id'])) {
            $user = new User();
            $user = $user->populate([
                'id' => (!empty($id)) ? $id : $_SESSION['user_id']
            ]);
        }
        if (!empty($user)) {
            $pictures = new Picture();
            $pictures = $pictures->getAllBy(['user_id' => $user->getId(), 'community_id' => $commu->getId()] , 'DESC');
            $v->assign('user', $user);
            $v->assign('pictures', $pictures);
            $v->assign('title', "Photos de ".$user->getUsername());
        }
    }

    public function album($community = null, $id = null) {
        $v = new View('album.index', 'frontend');
        $commu = $this->checkCommunity($community);
        $v->assign('community', $commu);
        if (empty($id)) {
            // Listing des albums
        } else {
            // Affichage d'un album avec $id
            $album = new Album();
            $album = $album->populate(['id' => $id, 'community_id' => $commu->getId()]);
            if (!empty($album)) {
                $author = new User();
                $author = $author->populate(['id' => $album->getUserId()]);
                $pictures = new Picture();
                $pictures = $pictures->getAllBy(['user_id' => $author->getId(), 'community_id' => $commu->getId()]);
                $picturesAlbum = new Picture_Album();
                $picturesAlbum = $picturesAlbum->getAllBy(['album_id' => $id]);

                $v->assign('author', $author);
                $v->assign('pictures', $pictures);
                $v->assign('picturesAlbum', $picturesAlbum);
                $v->assign('title', $album->getTitle());
            }
            $v->assign('album', $album);
        }
    }

    public function albums($community = null, $id = null) {
        $v = new View('user.albums', 'frontend');
        $commu = $this->checkCommunity($community);
        $v->assign('community', $commu);
        if (!empty($id) || isset($_SESSION['user_id'])) {
            $user = new User();
            $user = $user->populate([
                'id' => (!empty($id)) ? $id : $_SESSION['user_id']
            ]);
        }
        if (!empty($user)) {
            $albums = new Album();
            $albums = $albums->getAllBy(['user_id' => $user->getId(), 'community_id' => $commu->getId()], 'DESC');
            $v->assign('user', $user);
            $v->assign('albums', $albums);
            $v->assign('title', "Album de ".$user->getUsername());
        }
    }

}
