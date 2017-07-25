<?php
class UserController {

    public function __construct(){
        if(!isset($_SESSION['user_id'])){
            header('Location:/login');
        }

        $community = new Community;
        $url = $_SERVER['REQUEST_URI'];
        $extracted = array_filter(explode("/",parse_url($url,PHP_URL_PATH)));
        $community = $community->populate(['slug'=>current($extracted)]);

        if ($community) {
            $_SESSION['community_slug'] = $community->getSlug();
            $_SESSION['community_name'] = $community->getName();
            $_SESSION['community_id'] = $community->getId();

            $community_user = new Community_User();
            $community_user = $community_user->populate(['community_id'=>$community->getId(), 'user_id'=>$_SESSION['user_id']]);
            if($community_user != false){
                $_SESSION['permission'] = $community_user->getPermission();
            } else {
                $_SESSION['permission'] = 0;
            }
        }

    }

    public function checkCommunity($community) {

        if (!empty($community)) {
            $commu = new Community();
            $commu = $commu->populate(['slug'=>$community]);
            if (!$commu) {
                $_SESSION['messages']['error'][] = "La communauté n'a pas été trouvée";
                $v = new View("404", "frontend");
                return 0;
            }
            return $commu;
        }
    }

    public function flagComment(){
        $flag = new Flag_Comment('DEFAULT', $_SESSION['user_id'], $_POST['id']);
        $flag->save();

        $_SESSION['messages']['success'][] = "Vous avez bien signalé ce commentaire";
        GlobalController::flash('json');
    }
    public function unFlagComment(){
        $flag = new Flag_Comment();
        $flag->deleteOneBy(['user_id'=>$_SESSION['user_id'], 'comment_id'=>$_POST['id']]);

        $_SESSION['messages']['success'][] = "Signalement correctement retiré";
        GlobalController::flash('json');
    }

//TODO ADD POSSIBILITY FOR USER TO EDIT / DELET OWN COMMENT
    /*
     * Page de profil (/user)
    */
    public function index($community = null) {
        if ($_SESSION) {
            $user = new User();
            $user = $user->populate(array('username' => $_SESSION['username']));
            $userId = $user->getId();
            $v = new View('user.index', 'frontend');
            $v->assign('user', $user);
            $v->assign('title', "Profil de ".$user->getUsername());
            $commu = $this->checkCommunity($community);
            $v->assign('community', $commu);
            /*
             * Formulaire "Profil"
             */
            if (isset($_POST["profil"])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : "";
                $confpwd = isset($_POST['confpwd']) ? $_POST['confpwd'] : "";
                $usernameTaken = (new User())->getAllBy(['username' => $username]);
                $emailTaken = (new User())->getAllBy(['email' => $email]);

                if (
                    $pwd == $confpwd &&
                    (empty($usernameTaken) || $usernameTaken[0]["id"] == $userId) &&
                    (empty($emailTaken) || $emailTaken[0]["id"] == $userId)
                ) {
                    $now = new DateTime("now");
                    $nowStr = $now->format("Y-m-d H:i:s");
                    $user->setUsername(htmlspecialchars(trim($username)));
                    $user->setEmail(htmlspecialchars(trim($email)));
                    if ($pwd != "" && $confpwd != "") $user->setPassword($pwd);
                    $user->setUpdatedAt($nowStr);
                    $user->save();
                    $_SESSION["username"] = $username;
                    $_SESSION['messages']['success'][] = "Profil mis à jour";
                }
                if ($pwd != $confpwd) {
                    $_SESSION['messages']['warning'][] = "Les mots de passe sont différents";
                }
                if (!empty($usernameTaken) && $usernameTaken[0]["id"] != $userId) {
                    $_SESSION['messages']['warning'][] = "Cet identifiant est déjà pris";
                }
                if (!empty($emailTaken) && $emailTaken[0]["id"] != $userId) {
                    $_SESSION['messages']['warning'][] = "Cet email existe déjà";
                }
            }

            /*
             * Formulaire "Informations personnelles"
             */
            if (isset($_POST["infos"])) {
                $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
                $lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
                $avatar = isset($_FILES["avatar"]) ? $_FILES["avatar"] : [];
                $user->setFirstname(htmlspecialchars(trim($firstname)));
                $user->setLastname(htmlspecialchars(trim($lastname)));
                if (isset($_FILES["avatar"])) {
                    if ($_FILES['avatar']['error'] > 0) {
                        if ($_FILES['avatar']['error'] == 1 || $_FILES['avatar']['error'] == 2)
                            $_SESSION['messages']['warning'][] = "Le fichier d'avatar est trop volumineux (max: 5 Mo)";
                        elseif ($_FILES['avatar']['error'] != 4)
                            $_SESSION['messages']['warning'][] = "Le fichier d'avatar a rencontré une erreur.";
                    } else {
                        $fileInfo = pathinfo($_FILES['avatar']['name']);
                        if (
                            strtolower($fileInfo["extension"]) == "jpg" ||
                            strtolower($fileInfo["extension"]) == "jpeg" ||
                            strtolower($fileInfo["extension"]) == "png" ||
                            strtolower($fileInfo["extension"]) == "gif"
                        ) {
                            $nameAvatar = "SP_".uniqid().".".strtolower($fileInfo["extension"]);
                            move_uploaded_file($_FILES['avatar']['tmp_name'], "./public/cdn/images/avatars/".$nameAvatar);
                            $user->setAvatar($nameAvatar);
                            $_SESSION['messages']['success'][] = "Votre avatar a été ajouté";
                        } else {
                            $_SESSION['messages']['warning'][] = "Format d'image invalide<br>(essayez: .jpg, .jpeg, .png ou .gif)";
                        }
                    }
                } else {
                    $_SESSION['messages']['warning'][] = "Aucun avatar sélectionné";
                }
                $now = new DateTime("now");
                $nowStr = $now->format("Y-m-d H:i:s");
                $user->setUpdatedAt($nowStr);
                $user->save();
                $_SESSION['messages']['success'][] = "Informations personnelles mises à jour";
            }
        } else {
            $v = new View('index', 'frontend');
        }
    }

    public function actions() {

    }

    public function pictures($id = null) {
        $v = new View('user.pictures', 'frontend');
        if (!empty($id) || isset($_SESSION['user_id'])) {
            $user = new User();
            $user = $user->populate([
                'id' => (!empty($id)) ? $id : $_SESSION['user_id']
            ]);
        }
        if (!empty($user)) {
            $pictures = new Picture();
            $pictures = $pictures->getAllBy(['user_id' => $user->getId()], 'DESC');
            $v->assign('user', $user);
            $v->assign('pictures', $pictures);
            $v->assign('title', "Photos de ".$user->getUsername());
        }
    }

    public function albums($id = null) {
        $v = new View('user.albums', 'frontend');
        if (!empty($id) || isset($_SESSION['user_id'])) {
            $user = new User();
            $user = $user->populate([
                'id' => (!empty($id)) ? $id : $_SESSION['user_id']
            ]);
        }
        if (!empty($user)) {
            $albums = new Album();
            $albums = $albums->getAllBy(['user_id' => $user->getId()], 'DESC');
            $v->assign('user', $user);
            $v->assign('albums', $albums);
            $v->assign('title', "Album de ".$user->getUsername());
        }
    }

    public function addComment(){
        if (isset($_POST['content'])) {
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
                $_SESSION['messages']['success'][] = "Votre commentaire a été ajouté<br>et est en attente de validation";
            } else {
                $_SESSION['messages']['warning'][] = "Votre commentaire ne peut pas être vide";
            }
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: /");
    }
}
