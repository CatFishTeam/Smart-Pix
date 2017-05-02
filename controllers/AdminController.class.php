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
    }

    public function pagesAction(){
        $v = new View('admin.pages','backend');
        $v->assign("specificHeader","<script src=\"hgfjhgjlkhvk\"></script>");
    }

    public function mediasAction(){
        $v = new View('admin.medias','backend');
    }

    public function mediaUploadAction(){
        var_dump($_FILES);
        // var_dump($_POST);
        //TODO Taille du fichier ?
        $file = is_uploaded_file($_FILES["file"]["tmp_name"]);
        if(!$file){
            echo "Problème lors du transfert";
        } else {

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
