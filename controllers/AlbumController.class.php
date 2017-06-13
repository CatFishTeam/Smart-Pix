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
        exit;
    }

    public function showEditAction(){
        $album = new Album();
        echo json_encode($album->getOneBy(['id'=>$_POST['id']]));
        exit;
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
        exit;
    }

    public function deleteAlbumAction(){
        $album = new Album();
        $album->deleteOneBy(['id'=>$_POST['id']]);
        echo json_encode("success");
        exit;
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
            }
            $v->assign('album', $album);
        }
    }

    public function createAction() {
        $v = new View("album.create", "frontend");
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
                header("Location: ".PATH_RELATIVE."album/".$album->getDb()->lastInsertId());
                $flash .= "<div class='flash flash-success'><div class='flash-cell'>Votre album a été créé</div></div>";
            } else {
                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>La création de l'album a échoué</div></div>";
            }
            $flash .= "</div>";
            echo $flash;
        }
    }

}
