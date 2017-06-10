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
        $comment->setIsArchived(0);
        $comment->save();

        header('Location: '.$_SERVER['HTTP_REFERER']);


    }
    // protected $id = -1;
    // protected $content;
    // protected $created_at;
    // protected $picture_id; //Rajouter User / Alubm ?
    // protected $is_archived;
}
