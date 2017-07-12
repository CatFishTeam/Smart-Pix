<?php
include 'GlobalController.class.php';

class UserController extends GlobalController{

//TODO PK USER CONNECTÉ PERMISSION 2 DE BASE
//TODO ADD POSSIBILITY FOR USER TO EDIT / DELET OWN COMMENT
    /*
     * Page de profil (/user)
     */
    public function index() {
        if ($_SESSION) {
            $user = new User();
            $user = $user->populate(array('username' => $_SESSION['username']));
            $userId = $user->getId();
            $v = new View('user.index', 'frontend');
            $v->assign('user', $user);
            $v->assign('title', "Profil de ".$user->getUsername());

            /*
             * Formulaire "Profil"
             */
            if (isset($_POST["profil"])) {
                $flash = '<div class="flash-container">';
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
                    $flash .= "<div class='flash flash-success'><div class='flash-cell'>Profil mis à jour</div></div>";
                }
                if ($pwd != $confpwd) {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Les mots de passe sont différents</div></div>";
                }
                if (!empty($usernameTaken) && $usernameTaken[0]["id"] != $userId) {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Cet identifiant est déjà pris</div></div>";
                }
                if (!empty($emailTaken) && $emailTaken[0]["id"] != $userId) {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Cet email existe déjà</div></div>";
                }
                $flash .= "</div>";
                echo $flash;
            }

            /*
             * Formulaire "Informations personnelles"
             */
            if (isset($_POST["infos"])) {
                $flash = '<div class="flash-container">';
                $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
                $lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
                $avatar = isset($_FILES["avatar"]) ? $_FILES["avatar"] : [];
                $user->setFirstname(htmlspecialchars(trim($firstname)));
                $user->setLastname(htmlspecialchars(trim($lastname)));
                if (isset($_FILES["avatar"])) {
                    if ($_FILES['avatar']['error'] > 0) {
                        if ($_FILES['avatar']['error'] == 1 || $_FILES['avatar']['error'] == 2)
                            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Le fichier d'avatar est trop volumineux (max: 5 Mo)</div></div>";
                        elseif ($_FILES['avatar']['error'] != 4)
                            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Le fichier d'avatar a rencontré une erreur.</div></div>";
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
                            $flash .= "<div class='flash flash-success'><div class='flash-cell'>Votre avatar a été ajouté</div></div>";
                        } else {
                            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Format d'image invalide<br>(essayez: .jpg, .jpeg, .png ou .gif)</div></div>";
                        }
                    }
                } else {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Aucun avatar sélectionné</div></div>";
                }
                $now = new DateTime("now");
                $nowStr = $now->format("Y-m-d H:i:s");
                $user->setUpdatedAt($nowStr);
                $user->save();
                $flash .= "<div class='flash flash-success'><div class='flash-cell'>Informations personnelles mises à jour</div></div>";
                $flash .= "</div>";
                echo $flash;
            }
        } else {
            $v = new View('index', 'frontend');
        }
    }

    public function picturesAction($id) {
        $v = new View('user.pictures', 'frontend');
        if (!empty($id)) {
            $user = new User();
            $user = $user->populate(['id' => $id[0]]);
        }
        if (!empty($user)) {
            $pictures = new Picture();
            $pictures = $pictures->getAllBy(['user_id' => $user->getId()]);
            $v->assign('user', $user);
            $v->assign('pictures', $pictures);
            $v->assign('title', "Photos de ".$user->getUsername());
        }
    }

    public function addComment(){
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

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: /");
    }
}
