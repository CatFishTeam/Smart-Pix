<?php
class CommentController{


    public function addAction(){
        $comment = new Comment();
        $now = new DateTime("now");
        $nowStr = $now->format("Y-m-d H:i:s");
        $comment->setContent($_POST['content']);
        $comment->setCreatedAt($nowStr);
        $comment->setPictureId($_POST['id']);
        $comment->setUserId($_SESSION['user_id']);
        $comment->save();

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    //If user whant to delete his own comment
    public function deleteAction(){

    }
}
