<?php
class AlbumController{

    public function addalbumAction(){
        $album = new Album();
        $now = new DateTime("now");
        $nowStr = $now->format("Y-m-d H:i:s");
        $album->setTitle($_POST['title']);
        $album->setDescription($_POST['description']);
        $album->setUserId($_SESSION['user_id']);
        if(isset($_POST['is_presentation'])){
            $album->setIsPresentation(1);
        } else {
            $album->setIsPresentation(0);
        }
        $album->setIsDeleted(0);
        $album->setCreatedAt($nowStr);
        $album->setUpdatedAt($nowStr);
        $album->save();
    }
}
