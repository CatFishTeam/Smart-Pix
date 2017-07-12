<?php

class PagesController{

    public function index(){
        $v = new View();
        $pictures = new Picture();
        $pictures = $pictures->getAllBy([], 'DESC');
        $v->assign('pictures', $pictures);
    }

    public function album($id) {
        $v = new View('album.index', 'frontend');
        if (empty($id)) {
            // Listing des albums

        } else {
            // Affichage d'un album avec $id
            $album = new Album();
            $album = $album->populate(['id' => $id[0]]);
            if (!empty($album)) {
                $author = new User();
                $author = $author->populate(['id' => $album->getUserId()]);
                $pictures = new Picture();
                $pictures = $pictures->getAllBy(['user_id' => $author->getId()]);
                $v->assign('author', $author);
                $v->assign('pictures', $pictures);
                $v->assign('title', $album->getTitle());
            }
            $v->assign('album', $album);
        }
    }

    /*
     * Page d'une image (/picture/{id})
     * Si $id non fourni => listing des images sur le site
     */
     //TODO Message en attente de validation
    public function picture($id) {
        $v = new View('picture.index', 'frontend');
        $v->assign('id', $id);
        if (empty($id)) {
            // Listing des images
        } else {
            // Affichage d'une image avec $id
            $picture = new Picture();
            $picture = $picture->populate(['id' => $id[0]]);
            if (!empty($picture)) {
                $author = new User();
                $author = $author->populate(['id' => $picture->getUserId()]);
                $v->assign('author', $author);
                $v->assign('title', $picture->getTitle());
            }
            $v->assign('picture', $picture);

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
        if ($_POST) {
            $flash = '<div class="flash-container">';
            $user = new User();
            $username = $_POST['username'];
            $password = $_POST['pwd'];
            $user = $user->populate(array('username' => $username));

            if ($user) {
                if (password_verify($password, $user->getPassword()) && $user->getStatus() > 0) {
                    if (!isset($_SESSION)) session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['permission'] = $user->getPermission();
                    $userConnected = true;
                    header("Refresh:1; url=".PATH_RELATIVE, true, 303);
                    $flash .= "<div class='flash flash-success'><div class='flash-cell'>Vous êtes connecté !<br>Vous allez être redirigée...</div></div>";
                } elseif ($user->getStatus() == 0) {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Votre compte n'est pas activé</div></div>";
                } else {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Erreur lors de la connexion</div></div>";
                }
            } else {
                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Aucun utilisateur trouvé</div></div>";
            }
            $flash .= "</div>";
            echo $flash;
        }
        $v = new View('user.login', 'frontend');
        $v->assign('userConnected', $userConnected);
        $v->assign('title', "Connexion");
    }

    //TODO : Modifier pour qu'on utilise le constructeur de User (qu'il faut surement modifier un peu).
    public function signup() {
        $v = new View('user.signup', 'frontend');
        $v->assign('title', "Inscription");
    }

    //Wall d'un user
    public function wall($id = null) {
        //TODO ??

        $user = new User();
        if (empty($id) && !isset($_SESSION)) {
            $v = new View("index", "frontend");
            return 0;
        } elseif (empty($id) && isset($_SESSION['user_id'])) {
            $user = $user->populate(array('id' => $_SESSION['user_id']));
        } else {
            $user = $user->populate(array('id' => $id[0]));
            if (empty($user)) {
                var_dump("test3");
                //$v = new View("index", "frontend");
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

}
