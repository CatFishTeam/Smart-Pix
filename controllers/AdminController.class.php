<?php
class AdminController{

    public function __construct(){
        //TODO Middleware ?? !!
        if(!isset($_SESSION['user_id'])){
            header('Location:'.PATH_RELATIVE.'user/login');
        }
    }

    //RENAME SHOW PAGE CONTROLLER ?
    public function indexAction(){
        $v = new View('admin.index','backend');
        $v->assign("test","yolo");
    }

    public function profilAction(){
        $v = new View('admin.profil','backend');
        $v->assign("specificHeader","<script src=\"https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js\"></script>");
    }

    public function albumsAction(){
        $v = new View('admin.albums','backend');

        $albums = new Album();
        $albums = $albums->getAllBy(['user_id'=>$_SESSION['user_id']], "DESC");
        $v->assign('albums',$albums);

        $pictures = new Picture();
        $pictures = $pictures->getAllBy(['user_id'=>$_SESSION['user_id']], "DESC");
        $v->assign('pictures',$pictures);
    }


    public function mediaAction($id){
        $v = new View('admin.settings','backend');
        $v->assign('id',$id);
        var_dump($id);
    }

    public function mediasAction(){
        $v = new View('admin.medias','backend');

        $pictures = new Picture();
        $pictures = $pictures->getAllBy(['user_id'=>$_SESSION['user_id']], "DESC");
        $v->assign('pictures',$pictures);

        $totalWeight = 0;
        foreach ($pictures as $picture) {
            $totalWeight += $picture['weight'];
        }
        $v->assign('totalWeight',$totalWeight);


    }

    //Media Controller ou Ajax Controller ou Ici ?
    public function mediaUploadAction(){
        $upload_dir = '/public/cdn/images/';
        $upload_thumb_dir = '/public/cdn/images/thumbnails/';

        //If it is Ajax Request
        if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            //If File not empty
            if(!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])){
                $response = json_encode(array(
                    'type'=>'error',
                    'msg'=>'Le fichier image n\'a pas été fourni !'
                ));
                die($response);
            }

            //Check le type de l'image
            //TODO conversion pour thumbnail | faire test avec gif etc?
            $img_size = getimagesize($_FILES['file']['tmp_name']);
            if($img_size){
                $img_type = $img_size['mime'];
            }else{
                $response = json_encode(array(
                    'type'=>'error',
                    'msg'=>'Le fichier n\'est pas au bon format !'
                ));
                die($response);
            }

            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            //Stockage de l'image en base
            //TODO rajouter test de sauvegarde en bdd
            $picture = new Picture();
            $now = new DateTime("now");
            $nowStr = $now->format("Y-m-d H:i:s");
            //Il faudrait donc tous les champs ici ?
            $picture->setAlbumId(null);
            $picture->setUserId($_SESSION['user_id']);
            $picture->setTitle($_POST['title']);
            $picture->setDescription($_POST['description']);
            $picture->setUrl($ext);
            $picture->setWeight($_FILES['file']['size']);
            $picture->setIsVisible(0);
            $picture->setCreatedAt($nowStr);
            $picture->setUpdatedAt($nowStr);
            $picture->save();
            var_dump($picture);

            //On crée l'image
            $image = new Imagick($_FILES['file']['tmp_name']);
            $results = $image->writeImages(PATH_ABSOLUT.$upload_dir.$picture->getUrl(), true);

            //On crée la miniature
            //TODO Si possible ? Eviter la répétition ici ?
            $thumb = new Imagick($_FILES['file']['tmp_name']);
            $thumb->cropThumbnailImage(200, 200);
            $thumb->writeImages(PATH_ABSOLUT.$upload_thumb_dir.$picture->getUrl(), true);

            if($results){
                $response = json_encode(array(
                    'type'=>'succes',
                    'msg'=>'L\'image a bien été enregistrée',
                    'img'=>$picture->getUrl()
                ));
            }
        }
        die($response);
    }

    //TODO Répétiion de upload_dir et upload_dir thumb (changer de controller pour ca)
    public function mediaDeleteAction(){
        $upload_dir = '/public/cdn/images/';
        $upload_thumb_dir = '/public/cdn/images/thumbnails/';

        $picture = new Picture();
        $delete = $picture->deleteOneBy(array('url'=>$_POST['url']));

        //Détruit les fichiers
        unlink(PATH_ABSOLUT.$upload_dir.$_POST['url']);
        unlink(PATH_ABSOLUT.$upload_thumb_dir.$_POST['url']);

        if($delete){
            $response = json_encode(array(
                'type'=>'succes',
                'msg'=>'L\'image a bien été supprimée'
            ));
            die($response);
        }
    }

    public function settingsAction(){
        $v = new View('admin.settings','backend');
    }

    public function commentsAction(){
        $v = new View('admin.comments','backend');

        $pictures = new Picture();
        $pictures = $pictures->getAllBy(['user_id'=>$_SESSION['user_id']]);

        $allComments = [];

        foreach ($pictures as $picture) {
            $comments = new Comment();
            $comments = $comments->getAllBy(['picture_id'=>$picture['id']]);
            foreach ($comments as $comment) {
                $user = new User();
                $comment['username'] =  $user->getOneBy(['id'=>$comment['user_id']])['username'];
                // echo "<pre>";
                // print_r($comment);
                // echo "</pre>";
            }
            echo "<pre>";
            print_r($comment);
            echo "</pre>";
            $allComments = array_merge($allComments, $comments);


        }

        $v->assign('allComments', $allComments);

    }

    public function statsAction(){
        $v = new View('admin.stats','backend');
    }

    public function phpinfoAction(){
        phpinfo();
    }
}
