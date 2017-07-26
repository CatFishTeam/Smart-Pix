<?php
class PagesController{

    public function index(){
        $v = new View();
        $pictures = new Picture();
        $pictures = $pictures->getAllBy([], 'DESC');

        for($i = 0; $i < count($pictures); $i++){
            $community = new Community;
            $community = $community->getOneBy(['id'=>$pictures[$i]['community_id']]);
            $pictures[$i]['community_slug'] = $community['slug'];
            $pictures[$i]['community_name'] = $community['name'];
        }
        shuffle($pictures);
        $communities = new Community();
        $communities = $communities->getAllBy([], 'DESC',3);
        $users = new User();
        $users = $users->getAllBy([]);
        $v->assign('pictures', $pictures);
        $v->assign('communities', $communities);
        $v->assign('users', $users);
    }

    public function communityIndex($slug){
        $community = new Community();
        $community = $community->getOneBy(['slug'=>$slug]);

        $v = new View();
        $pictures = new Picture();
        $pictures = $pictures->getAllBy(['community_id' => $community['id']], 'DESC');
        $v->assign('pictures', $pictures);
    }

    public function album($id) {
        $v = new View('album.index', 'frontend');
        if (empty($id)) {
            // Listing des albums

        } else {
            // Affichage d'un album avec $id
            $album = new Album();
            $album = $album->populate(['id' => $id]);
            if (!empty($album)) {
                $author = new User();
                $author = $author->populate(['id' => $album->getUserId()]);
                $pictures = new Picture();
                $pictures = $pictures->getAllBy(['user_id' => $author->getId()]);
                $picturesAlbum = new Picture_Album();
                $picturesAlbum = $picturesAlbum->getAllBy(['album_id' => $id]);
                $v->assign('author', $author);
                $v->assign('pictures', $pictures);
                $v->assign('picturesAlbum', $picturesAlbum);
                $v->assign('title', $album->getTitle());
            }
            $v->assign('album', $album);
        }
    }

    public function picture($id = null) {
        $v = new View('picture.index', 'frontend');
        $v->assign('id', $id);
        if (empty($id)) {
            // Listing des images
            $allPictures = new Picture();
            $allPictures = $allPictures->getAllBy([], 'DESC');
            $v->assign('allPictures', $allPictures);
        } else {
            // Affichage d'une image avec $id
            $picture = new Picture();
            $picture = $picture->populate(['id' => $id]);
            if (!empty($picture)) {
                $author = new User();
                $author = $author->populate(['id' => $picture->getUserId()]);
                $v->assign('author', $author);
                $v->assign('title', $picture->getTitle());
            }
            $v->assign('picture', $picture);

            $albumsId = new Picture_Album();
            $albumsId = $albumsId->getAllBy(['picture_id' => $id]);

            $albums = array();
            foreach ($albumsId as $albumId) {
                $album = new Album();
                $album = $album->getOneBy(['id' => $albumId['album_id']]);
                array_push($albums, $album);
            }
            $v->assign('albums', $albums);

            $comments = new Comment();
            $comments = $comments->getAllBy(['picture_id'=>$id[0],'is_archived'=>0, 'is_published'=>1], 'DESC');
            $v->assign('comments', $comments);

            if(isset($_SESSION['user_id'])){
                $unpublishedComments = new Comment();
                $unpublishedComments = $unpublishedComments->getAllBy(['picture_id'=>$id[0], 'user_id'=>$_SESSION['user_id'], 'is_archived'=>0, 'is_published'=>0]);
                if(count($unpublishedComments) > 0){
                    $v->assign('unpublishedComments', count($unpublishedComments));
                }
            }

        }
    }

    public function login() {
        $userConnected = false;
        $v = new View('user.login', 'frontend');
        $v->assign('userConnected', $userConnected);
        $v->assign('title', "Connexion");
    }

    public function signup() {
        $v = new View('user.signup', 'frontend');
        $v->assign('title', "Inscription");
    }

    //Wall d'un user
    public function wall($id = null) {
        $user = new User();
        if (empty($id) && !isset($_SESSION)) {
            $v = new View("index", "frontend");
            return 0;
        } elseif (empty($id) && isset($_SESSION['user_id'])) {
            $user = $user->populate(array('id' => $_SESSION['user_id']));
        } else {
            $user = $user->populate(array('id' => $id));
            if (empty($user)) {
                header("Location: /");
            }
        }
        $userId = $user->getId();
        $actions =  new Action();
        $actions = $actions->getAllBy(['user_id' => $userId], 'DESC');
        $pictures = new Picture();
        $pictures = $pictures->getAllBy(['user_id' => $userId], 'DESC', 14);
        $albums = new Album();
        $albums = $albums->getAllBy(['user_id' => $userId], 'DESC', 14);

        $v = new View('user.wall', 'frontend');
        $v->assign('user', $user);
        $v->assign('actions', $actions);
        $v->assign('pictures', $pictures);
        $v->assign('albums', $albums);
        $v->assign('title', $user->getUsername());
    }

    public function error(){
        $v = new View('404', 'frontend');
    }

    public function search() {
        if ($_POST) {
            $v = new View("search", "frontend");
            $search = trim(htmlspecialchars($_POST['search']));
            $resCommu = new Community();
            $resCommu = $resCommu->like(['name' => $search, 'description' => $search]);
            $resPicture = new Picture();
            $resPicture = $resPicture->like(['title' => $search, 'description' => $search]);
            $resUser = new User();
            $resUser = $resUser->like(['username' => $search]);

            $v->assign('search', $search);
            $v->assign('resCommu', $resCommu);
            $v->assign('resPicture', $resPicture);
            $v->assign('resUser', $resUser);
        } else {
            $v = new View("404");
            $_SESSION['messages']['error'][] = "La recherche a rencontré une erreur";
        }
    }

}
