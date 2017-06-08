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
}
