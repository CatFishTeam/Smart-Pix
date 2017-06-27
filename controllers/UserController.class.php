<?php

class UserController {

    /*
     * Page de profil (/user)
     */
    public function indexAction() {
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

    //TODO : Modifier pour qu'on utilise le constructeur de User (qu'il faut surement modifier un peu).
    public function signupAction() {
        require_once __DIR__ . '/../vendor/autoload.php';
        // Si le formulaire a été envoyé :
        $flash = '<div class="flash-container">';
        if ($_POST && !empty($_POST['g-recaptcha-response'])) {
            $captchaSecret = "6LeftiQUAAAAAK0ofViC7O1cbx0Kw2_Mm2NFNSxO";
            $captchaResponse = $_POST["g-recaptcha-response"];
            $recaptcha = new \ReCaptcha\ReCaptcha($captchaSecret);
            $response = $recaptcha->verify($captchaResponse, $_SERVER['REMOTE_ADDR']);
            if ($response->isSuccess()) {
                $user = new User();
                $username = $_POST['username'];
                $email = $_POST['email'];
                $pwd = $_POST['pwd'];
                $confpwd = $_POST['confpwd'];
                $usernameTaken = (new User())->getAllBy(['username' => $_POST['username']]);
                $emailTaken = (new User())->getAllBy(['email' => $_POST['email']]);

                if ($pwd == $confpwd && empty($usernameTaken) && empty($emailTaken)) {
                    $now = new DateTime("now");
                    $nowStr = $now->format("Y-m-d H:i:s");
                    $user->setUsername(htmlspecialchars(trim($username)));
                    $user->setEmail(htmlspecialchars(trim($email)));
                    $user->setPassword(htmlspecialchars(trim($pwd)));
                    $user->setAvatar("");
                    $user->setFirstname("");
                    $user->setLastname("");
                    $user->setCreatedAt($nowStr);
                    $user->setUpdatedAt($nowStr);
                    $user->setPermission(1);
                    $user->setIsArchived(0);
                    $user->setStatus(0);
                    $accessToken = md5(uniqid()."hbfuigs".time());
                    $user->setAccessToken($accessToken);
                    $user->save();

                    // Action correspondante :
                    $action = new Action();
                    $action->setUserId($user->getDb()->lastInsertId());
                    $action->setTypeAction("signup");
                    $action->setRelatedId($user->getDb()->lastInsertId());
                    $action->setCreatedAt($nowStr);
                    $action->save();

                    // Envoi du mail :
                    require './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

                    $mail = new PHPMailer(); // create a new object
                    $mail->IsSMTP(); // enable SMTP
                    $mail->CharSet = 'UTF-8';
                    $mail->SMTPAuth = true; // authentication enabled
                    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 465; // or 587
                    $mail->IsHTML(true);
                    $mail->Username = "noreply.smartpix@gmail.com";
                    $mail->Password = MAILER_PWD;
                    $mail->SetFrom("no-reply@smart-pix.fr");
                    $mail->Subject = "Votre inscription sur Smart-Pix !";
                    $mail->Body = "<img src='http://smart-pix.fr/public/image/logo.png' width='100'>".
                        "<br>Bonjour ".$username.
                        "<br><br>Votre inscription sur Smart-Pix a bien été validée !
                    <br><br>Votre identifiant : ".$username.
                        "<br>Votre mot de passe : vous seul le connaissez !
                    <br><a href='http://smart-pix.dev/user/activate/".$accessToken."'>Activer votre compte</a>
                    <br><br>Cordialement,<br>L'équipe Smart-Pix";
                    $mail->AddAddress($email);

                    if(!$mail->Send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    }

                    $flash .= "<div class='flash flash-success'><div class='flash-cell'>Inscription terminée !<br>Vous allez recevoir un email de confirmation</div></div>";
                }  if ($pwd != $confpwd) {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Les mots de passe sont différents</div></div>";
                }  if (!empty($usernameTaken)) {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Cet identifiant est déjà pris</div></div>";
                }  if (!empty($emailTaken)) {
                    $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Cet email existe déjà</div></div>";
                }
            } else {
                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Erreur lors de la validation reCAPTCHA</div></div>";
            }

        } elseif ($_POST && empty($_POST['g-recaptcha-response'])) {
            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Erreur lors de la validation reCAPTCHA</div></div>";
        }
        $flash .= "</div>";
        echo $flash;
        $v = new View('user.signup', 'frontend');
        $v->assign('title', "Inscription");
    }

    public function activateAction($token) {
        $flash = '<div class="flash-container">';
        $user = new User();
        $user = $user->populate(array('access_token' => $token[0]));

        if (!empty($user) && $user->getStatus() == 0) {
            $user->setStatus(1);
            $user->save();
            $username = $user->getUsername();
            $password = $user->getPassword();
            if (!isset($_SESSION)) session_start();
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user->getId();
            $flash .= "<div class='flash flash-success'><div class='flash-cell'>Inscription confirmée !<br>Vous allez être redirigé...</div></div>";
            header( "Refresh:3; url=".PATH_RELATIVE, true, 303);
        } elseif(!empty($user) && $user->getStatus() == 1) {
            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Inscription déjà validée<br>Vous allez être redirigée vers la connexion...</div></div>";
            header( "Refresh:3; url=".PATH_RELATIVE."user/login", true, 303);
        } else {
            $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Erreur lors de la confirmation</div></div>";
        }
        $flash .= "</div>";
        echo $flash;
        $v = new View('user.activate', 'frontend');
        $v->assign('title', "Activation du compte");
    }

    public function loginAction() {
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

    public function logoutAction() {
        session_unset();
        session_destroy();
        //$v = new View('index', 'frontend');
        header("Location: /");
    }

    public function forgetPasswordAction() {
        if ($_POST) {
            $flash = '<div class="flash-container">';
            $email = trim(htmlspecialchars($_POST['email']));
            $emailExists = (new User())->getAllBy(['email' => $email]);
            if (!empty($email) && $emailExists) {
                $user = new User();
                $user = $user->populate(['email' => $email]);
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $tempPwd = '';
                for ($i = 0; $i < 8; $i++) {
                    $tempPwd .= $characters[rand(0, $charactersLength - 1)];
                }
                $user->setPassword($tempPwd);
                $user->save();
                // Envoi du mail :
                require './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

                $mail = new PHPMailer(); // create a new object
                $mail->IsSMTP(); // enable SMTP
                $mail->CharSet = 'UTF-8';
                $mail->SMTPAuth = true; // authentication enabled
                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 465; // or 587
                $mail->IsHTML(true);
                $mail->Username = "noreply.smartpix@gmail.com";
                $mail->Password = MAILER_PWD;
                $mail->SetFrom("no-reply@smart-pix.fr");
                $mail->Subject = "Mot de passe temporaire Smart-Pix";
                $mail->Body = "<img src='http://smart-pix.fr/public/image/logo.png' width='100'>".
                    "<br>Bonjour ".$user->getUsername().
                    "<br><br>Votre mot de passe temporaire : ".$tempPwd.
                    "<br><br>Cordialement,<br>L'équipe Smart-Pix";
                $mail->AddAddress($email);

                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }

                $flash .= "<div class='flash flash-success'><div class='flash-cell'>Un email vous a été envoyé</div></div>";
            } else {
                $flash .= "<div class='flash flash-warning'><div class='flash-cell'>Erreur : email introuvable </div></div>";
            }
            $flash .= "</div>";
            echo $flash;
        }
        $v = new View('user.forgetPassword', 'frontend');
    }

    public function wallAction($id) {
        //TODO ??
        $user = new User();
        if (empty($id) && !isset($_SESSION)) {
            $v = new View("index", "frontend");
            return 0;
        } elseif (empty($id) && $_SESSION) {
            $user = $user->populate(array('id' => $_SESSION['user_id']));
        } else {
            $user = $user->populate(array('id' => $id[0]));
            if (empty($user)) {
                $v = new View("index", "frontend");
                return 0;
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
}
