<?php
class AlbumController{

    public function add(){
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
        exit;
    }

    public function showEdit(){
        $album = new Album();
        echo json_encode($album->getOneBy(['id'=>$_POST['id']]));
        exit;
    }

    // TODO AJOUTER is_published
    // TODO retourner un objet json
    public function editAlbum(){
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
        exit;
    }

    public function deleteAlbum(){
        $album = new Album();
        $album->deleteOneBy(['id'=>$_POST['id']]);
        echo json_encode("success");
        exit;
    }

    public function create() {
        $v = new View("album.create", "frontend");
        $v->assign('title', "Ajout d'un album");
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
                if (isset($_FILES["thumbnail_url"])) {
                    if ($_FILES['thumbnail_url']['error'] > 0) {
                        if ($_FILES['thumbnail_url']['error'] == 1 || $_FILES['thumbnail_url']['error'] == 2)
                            $_SESSION['messages']['warning'][] = "Le fichier d'image est trop volumineux (max: 5 Mo)";
                        elseif ($_FILES['thumbnail_url']['error'] != 4)
                            $_SESSION['messages']['warning'][] = "Le fichier d'image a rencontré une erreur.";
                    } else {
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
                $action->setTypeAction("album");
                $action->setRelatedId($album->getDb()->lastInsertId());
                $action->setCreatedAt($nowStr);
                $action->save();
                header("Location: ".PATH_RELATIVE."album/".$album->getDb()->lastInsertId());
                $_SESSION['messages']['success'][] = "Votre album a été créé";
            } else {
                $_SESSION['messages']['warning'][] = "La création de l'album a échoué";
            }
        }
    }

    public function edit($id)
    {
        if (!isset($id) || empty($id) || !isset($_SESSION['user_id'])) {
            header('Location: /');
        } else {
            $album = new Album();
            $album = $album->populate(['id' => $id]);

            $v = new View('album.edit', 'frontend');
            if (!empty($album)) {
                $v->assign('album', $album);
            }

            // Envoi du formulaire :
            if ($_POST) {
                $title = htmlspecialchars(trim($_POST['title']));
                $description = htmlspecialchars(trim($_POST['description']));
                if (!empty($title) && !empty($description)) {
                    $album->setTitle($title);
                    $album->setDescription($description);
                    if (isset($_FILES["thumbnail_url"])) {
                        if ($_FILES['thumbnail_url']['error'] > 0) {
                            if ($_FILES['thumbnail_url']['error'] == 1 || $_FILES['thumbnail_url']['error'] == 2)
                                $_SESSION['messages']['warning'][] = "Le fichier d'image est trop volumineux (max: 5 Mo)";
                            elseif ($_FILES['thumbnail_url']['error'] != 4)
                                $_SESSION['messages']['warning'][] = "Le fichier d'image a rencontré une erreur.";
                        } else {
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

                                $_SESSION['messages']['success'][] =  "L'image de couverture a été ajoutée";
                            } else {
                                $_SESSION['messages']['warning'][] = "Format d'image invalide<br>(essayez: .jpg, .jpeg, .png ou .gif)";
                            }
                        }
                    } else {
                        $_SESSION['messages']['warning'][] = "Aucune image sélectionnée";
                    }
                }
                $now = new DateTime("now");
                $nowStr = $now->format("Y-m-d H:i:s");
                $album->setUpdatedAt($nowStr);
                $album->save();
                $_SESSION['messages']['success'][] = "Votre album a été mis à jour";
            }
        }
    }

}
