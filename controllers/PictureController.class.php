<?php

class PictureController {

    /*
     * Ajout d'une image par un user (/picture/create)
     */
    public function createAction() {
        $v = new View("picture.create", "frontend");
        $v->assign('title', "Ajout d'une image");
        if ($_POST) {
            $flash = '<div class="flash-container">';
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $picture = new Picture();

            if (!empty($title) && !empty($description)) {
                $picture->setUserId($_SESSION['user_id']);
                $picture->setAlbumId(null);
                $picture->setTitle($title);
                $picture->setDescription($description);
                if (isset($_FILES["picture"])) {
                    if ($_FILES['picture']['error'] > 0) {
                        if ($_FILES['picture']['error'] == 1 || $_FILES['picture']['error'] == 2)
                            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Le fichier d'image est trop volumineux (max: 5 Mo)</div></div>";
                        elseif ($_FILES['picture']['error'] != 4)
                            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Le fichier d'image a rencontré une erreur.</div></div>";
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
                            $picture->setCreatedAt($nowStr);
                            $picture->setUpdatedAt($nowStr);
                            $picture->save();
                            // Create related action
                            $action = new Action();
                            $action->setUserId($_SESSION['user_id']);
                            $action->setTypeAction("picture");
                            $action->setRelatedId($picture->getDb()->lastInsertId());
                            $action->setCreatedAt($nowStr);
                            $action->save();
                            move_uploaded_file($_FILES['picture']['tmp_name'], "./public/cdn/images/".$picture->getUrl());
                            header("Location: ".PATH_RELATIVE."picture/".$picture->getDb()->lastInsertId());
                            $flash .= "<div class='flash flash-success'><div class='flash-cell'>Votre image a été ajoutée</div></div>";
                        } else {
                            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Format d'image invalide<br>(essayez: .jpg, .jpeg, .png ou .gif)</div></div>";
                        }
                    }
                } else {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Aucune image sélectionnée</div></div>";
                }
            }

            $flash .= "</div>";
            echo $flash;

        }
    }

}
