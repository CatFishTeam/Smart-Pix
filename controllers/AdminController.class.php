<?php
class AdminController{
    //Construct middleware être connecté !!

    //RENAME SHOW PAGE CONTROLLER ?
    public function indexAction(){
        $v = new View('admin.index','backend');

        $v->assign("test","yolo");
    }

    public function profilAction(){
        $v = new View('admin.profil','backend');
        $v->assign("specificHeader","<script src=\"https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js\"></script>");
    }

    public function pagesAction(){
        $v = new View('admin.pages','backend');
    }

    public function mediasAction(){
        $v = new View('admin.medias','backend');
    }

    //Media Controller ou Ajax Controller ou Ici ?
    public function mediaUploadAction(){
        //TODO Taille du fichier ?
        $file = is_uploaded_file($_FILES["file"]["tmp_name"]);
        if(!$file){
            echo "Problème lors du transfert";
        } else {
            $picture = new Picture();
            $picture->setTitle($_POST['title']);
            $picture->setDescription($_POST['description']);
            $picture->setIsVisible(0);
            $picture->save();
        }
    }

    public function settingsAction(){
        $v = new View('admin.settings','backend');
    }

    public function commentsAction(){
        $v = new View('admin.comments','backend');
    }

    public function statsAction(){
        $v = new View('admin.stats','backend');
    }
}
