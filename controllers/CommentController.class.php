<?php
class CommentController{


    public function addAction(){
        if (isset($_POST['content'])) {
            $flash = '<div class="flash-container">';
            $content = trim(htmlspecialchars($_POST['content']));
            if (!empty($content)) {
                $comment = new Comment();
                $now = new DateTime("now");
                $nowStr = $now->format("Y-m-d H:i:s");
                $comment->setContent($_POST['content']);
                $comment->setCreatedAt($nowStr);
                $comment->setPictureId($_POST['id']);
                $comment->setUserId($_SESSION['user_id']);
                $comment->save();
                $flash .= "<div class='flash flash-success'><div class='flash-cell'>Votre commentaire a été ajouté<br>et est en attente de validation</div></div>";
            } else {
                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Votre commentaire ne peut pas être vide</div></div>";
            }
            $flash .= "</div>";
            echo $flash;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        } else {
            header('Location: /');
        }
    }

    //If user whant to delete his own comment
    public function deleteAction(){

    }
}
