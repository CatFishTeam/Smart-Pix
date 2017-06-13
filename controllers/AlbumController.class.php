<?php
class AlbumController{

    public function addAlbumAction(){
        $album = new Album();
        $now = new DateTime("now");
        $nowStr = $now->format("Y-m-d H:i:s");
        $album->setTitle($_POST['title']);
        $album->setDescription("");
        $album->setUserId($_SESSION['user_id']);
        $album->setIsPresentation(0);
        $album->setIsPublished(1);
        $album->setCreatedAt($nowStr);
        $album->setUpdatedAt($nowStr);
        $album->save();

        echo json_encode($album->last($_SESSION['user_id']));
        die;
    }

    public function showEditAction(){
        $album = new Album();
        echo json_encode($album->getOneBy(['id'=>$_POST['id']]));
        die;
    }

    // TODO AJOUTER is_published
    // TODO retourner un objet json
    public function editAlbumAction(){
        $album = new Album();
        $now = new DateTime("now");
        $nowStr = $now->format("Y-m-d H:i:s");

        $album->populate(['id'=>$_POST['id']]);
        $album->setId($_POST['id']);
        $album->setTitle($_POST['title']);
        $album->setDescription($_POST['description']);
        $album->setUserId($_SESSION['user_id']);
        if(isset($_POST['is_presentation'])){
            $album->setIsPresentation(1);
        } else {
            $album->setIsPresentation(0);
        }
        if(isset($_POST['is_published'])){
            $album->setIsPublished(1);
        } else {
            $album->setIsPublished(0);
        }
        $album->setCreatedAt($nowStr);
        $album->setUpdatedAt($nowStr);
        $album->save();

        echo json_encode($album->getOneBy(['id'=>$_POST['id']]));
        die;
    }

    public function deleteAlbumAction(){
        $album = new Album();
        $album->deleteOneBy(['id'=>$_POST['id']]);

        echo json_encode("success");
        die;
    }

    public function indexAction($id) {
        $v = new View('album.index', 'frontend');
        if (empty($id)) {
            // Listing des albums

        } else {
            // Affichage d'un album avec $id
            $album = new Album();
            $album = $album->populate(['id' => $id[0]]);
            if (!empty($album)) {
                $author = new User();
                $author = $author->populate(['id' => $album->getUserId()]);
                $pictures = new Picture();
                $pictures = $pictures->getAllBy(['user_id' => $author->getId()]);
                $v->assign('author', $author);
                $v->assign('pictures', $pictures);
                $v->assign('title', $album->getTitle());
            }
            $v->assign('album', $album);
        }
    }

    public function createAction() {
        $v = new View("album.create", "frontend");
        $v->assign('title', "Ajout d'un album");
        if ($_POST) {
            $flash = '<div class="flash-container">';
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $album = new Album();

            if (!empty($title) && !empty($description)) {
                $now = new DateTime("now");
                $nowStr = $now->format("Y/m/d H:i:s");
                $album->setUserId($_SESSION['user_id']);
                $album->setTitle($title);
                $album->setDescription($description);
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
                $action->setTypeAction("album");
                $action->setRelatedId($album->getDb()->lastInsertId());
                $action->setCreatedAt($nowStr);
                $action->save();
                header("Location: ".PATH_RELATIVE."album/".$album->getDb()->lastInsertId());
                $flash .= "<div class='flash flash-success'><div class='flash-cell'>Votre album a été créé</div></div>";
            } else {
                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>La création de l'album a échoué</div></div>";
            }
            $flash .= "</div>";
            echo $flash;
        }
    }

    public function editAction($id)
    {
        if (!isset($id) || empty($id) || !isset($_SESSION)) {
            $v = new View('index', 'frontend');
        } else {
            $album = new Album();
            $album = $album->populate(['id' => $id[0]]);

            $v = new View('album.edit', 'frontend');
            if (!empty($album)) {
                $v->assign('album', $album);
            }

            // Envoi du formulaire :
            if ($_POST) {
                $flash = '<div class="flash-container">';
                $title = htmlspecialchars(trim($_POST['title']));
                $description = htmlspecialchars(trim($_POST['description']));
                if (!empty($title) && !empty($description)) {
                    $album->setTitle($title);
                    $album->setDescription($description);
                    if (isset($_FILES["thumbnail_url"])) {
                        if ($_FILES['thumbnail_url']['error'] > 0) {
                            if ($_FILES['thumbnail_url']['error'] == 1 || $_FILES['thumbnail_url']['error'] == 2)
                                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Le fichier d'image est trop volumineux (max: 5 Mo)</div></div>";
                            elseif ($_FILES['thumbnail_url']['error'] != 4)
                                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Le fichier d'image a rencontré une erreur.</div></div>";
                        } else {
                            var_dump($_FILES["thumbnail_url"]);
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

                                $flash .= "<div class='flash flash-success'><div class='flash-cell'>L'image de couverture a été ajoutée</div></div>";
                            } else {
                                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Format d'image invalide<br>(essayez: .jpg, .jpeg, .png ou .gif)</div></div>";
                            }
                        }
                    } else {
                        $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Aucune image sélectionnée</div></div>";
                    }
                }
                $now = new DateTime("now");
                $nowStr = $now->format("Y-m-d H:i:s");
                $album->setUpdatedAt($nowStr);
                $album->save();
                $flash .= "<div class='flash flash-success'><div class='flash-cell'>Votre album a été mis à jour</div></div>";
                $flash .= "</div>";
                echo $flash;
            }
        }
    }

}
