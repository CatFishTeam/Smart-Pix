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
                    <br><a href='http://smart-pix.dev/activate/".$accessToken."'>Activer votre compte</a>
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

    //Wall d'un user
    public function wall($id) {
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

}
