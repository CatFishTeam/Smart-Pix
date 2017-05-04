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
        // • USER ID
        // • Check présence du titre
        $file = is_uploaded_file($_FILES["file"]["tmp_name"]);
        if(!$file){
            echo "Problème lors du transfert";
        } else {
            $picture = new Picture();
            $now = new DateTime("now");
            $nowStr = $now->format("Y-m-d H:i:s");

            //Il faudrait donc tous les champs ici ?
            $picture->setAlbumId(null);
            $picture->setUserId(1);
            $picture->setTitle($_POST['title']);
            $picture->setDescription($_POST['description']);
            $picture->setUrl();
            $picture->setIsVisible(0);
            $picture->setCreatedAt($nowStr);
            $picture->setUpdatedAt($nowStr);
            $picture->save();

            //Upload
            $uploaddir = PATH_ABSOLUT.'/public/cdn/images/';
            $uploadfile = $uploaddir . $picture->getUrl().'jpg';
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            } else {
                Helpers::log(print_r($_FILES));
            }

            //Thumbnail
            // $picture->generateThumbnail()
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
