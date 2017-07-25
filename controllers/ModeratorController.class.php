<?php
include 'UserController.class.php';

//TODO CLEAAAAAN THIS FREAKING SHIIIT
//TODO Check edit album in admin !! (Integrity constraint violaiton)
//TODO check community_creator give him permanent acces in construct

class ModeratorController extends UserController{
    public function __construct(){
        parent::__construct();

        if($_SESSION['permission'] < 2){
            $_SESSION['messages']['warning'][] = "Seuls les administrateurs ont accès a cette partie du site !";
            header('Location:/'.$_SESSION['community_slug']);
        }
    }


    public function indexAdmin(){
        $pictures = new Picture;
        $pictures = $pictures->getAllBy(['community_id'=>$_SESSION['community_id']]);

        $albums = new Album;
        $albums = $albums->getAllBy(['community_id'=>$_SESSION['community_id']]);

        $users = [];
        $uc = new Community_User;
        $uc = $uc->getAllBy(['community_id'=>$_SESSION['community_id']]);
        foreach ($uc as $u) {
            $user = new User;
            $user = $user->getOneBy(['id'=>$u['user_id']]);
            $users[] = $user;
        }

        $v = new View('admin.index','backend');
        $v->assign('countPictures',count($pictures));
        $v->assign('countAlbums',count($albums));
        $v->assign('countUsers',count($users));
    }

    /* ~~~~ Album ~~~~*/
    public function showAlbums(){
        $v = new View('admin.albums','backend');

        $albums = new Album();
        $albums = $albums->getAllBy(['user_id'=>$_SESSION['user_id'], 'community_id'=>$_SESSION['community_id']], "DESC");
        $v->assign('albums',$albums);
    }

    public function addAlbum(){
        $album = new Album();
        $now = new DateTime("now");
        $nowStr = $now->format("Y-m-d H:i:s");
        $album->setTitle($_POST['title']);
        $album->setDescription($_POST['description']);
        $album->setUserId($_SESSION['user_id']);
        $album->setCommunityId($_SESSION['community_id']);
        $album->setIsPublished(0);
        $album->setCreatedAt($nowStr);
        $album->setUpdatedAt($nowStr);
        $album->save();

        echo json_encode($album->last($_SESSION['user_id']));
        exit;
    }

    public function getAlbum(){
        //Retourne les infos de l'album
        $datas = [];
        $album = new Album();
        $album = $album->getOneBy(['id'=>$_POST['id']]);
        $datas['album'] = $album;

        $picturesNotIn = new Picture;
        $picturesNotIn = $picturesNotIn->getAllBy(['community_id'=>$_SESSION['community_id']],"DESC");
        $picture_album = new Picture_album;
        $picture_album = $picture_album->getAllBy(['album_id'=>$_POST['id']]);
        foreach($picture_album as $picture){
            foreach($picturesNotIn as $key => $p){
                    if($picture['picture_id'] == $p['id']){
                        unset($picturesNotIn[$key]);
                    }
            }
        }
        $datas['picturesNotIn'] = (array)$picturesNotIn;

        //Retourne les photos qui sont dans l'album
        $pictures = [];
        $picture_album = new Picture_album;
        $picture_album = $picture_album->getAllBy(['album_id'=>$_POST['id']]);
        foreach ($picture_album as $key => $picture) {
            $p = new Picture();
            $p = $p->getOneBy(['id'=>$picture['picture_id']]);
            $pictures[$key] = $p;
        }
        $datas['pictures'] = $pictures;

        echo json_encode($datas);
        exit;
    }

    // TODO Retirer is_presentation
    public function editAlbum(){
        $album = new Album();
        $now = new DateTime("now");
        $nowStr = $now->format("Y-m-d H:i:s");

        $album->populate(['id'=>$_POST['id']]);
        $album->setId($_POST['id']);
        $album->setTitle($_POST['title']);
        $album->setDescription($_POST['description']);
        $album->setUserId($_SESSION['user_id']);
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

    public function deleteAlbum(){
        $album = new Album();
        $album->deleteOneBy(['id'=>$_POST['id']]);
        echo json_encode("success");
        exit;
    }

    public function addPictureToAlbum(){
        $picture_album = new Picture_Album;
        $picture_album->setPictureId($_POST['picture_id']);
        $picture_album->setAlbumId($_POST['album_id']);
        $picture_album->save();

        $picture = new Picture;
        $picture = $picture->getOneBy(['id'=>$_POST['picture_id']]);
        echo json_encode($picture);
        exit;
    }

    public function removePictureFromAlbum(){
        $picture_album = new Picture_Album;
        $picture_album = $picture_album->deleteOneBy(['picture_id'=>$_POST['id']]);
        $_SESSION['messages']['success'][] = "Image retirée de l'album";
        GlobalController::flash('json');
    }

    public function setPictureAsCover(){
        $picture = new Picture;
        $picture = $picture->populate(['id'=>$_POST['id']]);

        $album = new Album;
        $album = $album->populate(['id'=>$_POST['album_id']]);
        $album->setThumbnailUrl($picture->getUrl());
        $album->save();

        $_SESSION['messages']['success'][] = "Image de couverture modifié";
        GlobalController::flash('json');
    }

    /* ~~~~~ Picture ~~~~~*/
    public function medias(){
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
    public function uploadMedia(){
        $upload_dir = '/public/cdn/images/';
        // $upload_thumb_dir = '/public/cdn/images/thumbnails/';

        //If it is Ajax Request
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            //If File not empty
            if(!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])){
                $_SESSION['messages']['error'][] = "Le fichier image n'a pas été fourni !";
                GlobalController::flash('json');
            }

            //Check le type de l'image
            $img_size = getimagesize($_FILES['file']['tmp_name']);
            if($img_size){
                $img_type = $img_size['mime'];
            }else{
                $_SESSION['messages']['error'][] = "L'image n'est pas au bon format !";
                GlobalController::flash('json');
            }

            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            //Stockage de l'image en base
            $picture = new Picture();
            $now = new DateTime("now");
            $nowStr = $now->format("Y-m-d H:i:s");
            $picture->setAlbumId(null);
            $picture->setUserId($_SESSION['user_id']);
            $picture->setCommunityId($_SESSION['community_id']);
            $picture->setTitle($_POST['title']);
            $picture->setDescription($_POST['description']);
            $picture->setUrl($ext);
            $picture->setWeight($_FILES['file']['size']);
            $picture->setIsVisible(0);
            $picture->setIsArchived(0);
            $picture->setCreatedAt($nowStr);
            $picture->setUpdatedAt($nowStr);
            $picture->save();
            // var_dump($picture);

            //On crée l'image
            $image = new \Imagick($_FILES['file']['tmp_name']);
            $results = $image->writeImages(PATH_ABSOLUT.$upload_dir.$picture->getUrl(), true);

            // //On crée la miniature
            // $thumb = new \Imagick($_FILES['file']['tmp_name']);
            // $thumb->cropThumbnailImage(200, 200);
            // $thumb->writeImages(PATH_ABSOLUT.$upload_thumb_dir.$picture->getUrl(), true);

            if($results){
                $response = json_encode(array('url'=>$picture->getUrl(),'id'=>$picture->getDb()->lastInsertId()));
                echo $response;
            }
        }
        exit();
    }
    public function deleteMedia(){
        $upload_dir = '/public/cdn/images/';
        // $upload_thumb_dir = '/public/cdn/images/thumbnails/';

        $picture = new Picture();
        $delete = $picture->deleteOneBy(array('url'=>$_POST['url']));

        //Détruit les fichiers
        unlink(PATH_ABSOLUT.$upload_dir.$_POST['url']);
        // unlink(PATH_ABSOLUT.$upload_thumb_dir.$_POST['url']);

        if($delete){
            $_SESSION['messages']['success'][] = 'Image bien supprimée';
            GlobalController::flash('json');
            exit();
        }
    }

    public function unPublishMedia(){
        $picture = new Picture;
        $picture = $picture->populate(['url'=>$_POST['url']]);
        $picture->setIsVisible(1);
        $picture->save();
        $_SESSION['messages']['success'][] = 'Image dépubliée';
        GlobalController::flash('json');
        exit();
    }

    public function publishMedia(){
        $picture = new Picture;
        $picture = $picture->populate(['url'=>$_POST['url']]);
        $picture->setIsVisible(0);
        $picture->save();
        $_SESSION['messages']['success'][] = 'Image publiée';
        GlobalController::flash('json');
        exit();
    }

    /* ~~~~~~ Comments ~~~~~~ */
    public function comments(){
        $v = new View('admin.comments','backend');

        $pictures = new Picture();
        $pictures = $pictures->getAllBy(['user_id'=>$_SESSION['user_id']]);

        $allComments = [];
        $monarray = [];

        foreach ($pictures as $picture) {
            $comments = new Comment();
            $comments = $comments->getAllBy(['picture_id'=>$picture['id'],'is_archived'=>0]);

            foreach ($comments as $key=>$comment) {
                $user = new User();
                $comments[$key]['username'] =  $user->getOneBy(['id'=>$comment['user_id']])['username'];

                $flags = new Flag_Comment();
                $comments[$key]['nb_flags'] = count($flags->getAllBy(['comment_id'=>$comment['id']]));
            }
            $allComments = array_merge($allComments, $comments);
        }
        $v->assign('allComments', $allComments);
    }

    public function publishComment(){
        $comment = new Comment();
        $comment = $comment->populate(['id' => $_POST['id']]);
        $comment->setIsPublished(1);
        $comment->save();
        $_SESSION['messages']['success'][] = "Commentaire publié";
        GlobalController::flash('json');
        exit();
    }
    public function unpublishComment(){
        $comment = new Comment();
        $comment = $comment->populate(['id' => $_POST['id']]);
        $comment->setIsPublished(0);
        $comment->save();
        $_SESSION['messages']['success'][] = "Commentaire dépublié";
        GlobalController::flash('json');
        exit();
    }
    public function deleteComment(){
        $comment = new Comment();
        $comment->deleteOneBy(['id'=>$_POST['id']], true);
        $_SESSION['messages']['success'][] = "Commentaire supprimé";
        GlobalController::flash('json');
        exit();
    }

}
