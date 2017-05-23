<?php

class UserController {

    public function indexAction() {
        if ($_SESSION) {
            $user = new User();
            $user = $user->populate(array('username' => $_SESSION['username']));
            $v = new View('user.index', 'frontend');
            $v->assign('user', $user);
        } else {
            $v = new View('index', 'frontend');
        }
    }

    //TODO : Modifier pour qu'on utilise le constructeur de User (qu'il faut surement modifier un peu).
    public function signupAction() {
        // Si le formulaire a été envoyé :
        if ($_POST) {
            $flash = '<div class="flash-container">';
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
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword($pwd);
                $user->setAvatar("");
                $user->setFirstname("");
                $user->setLastname("");
                $user->setCreatedAt($nowStr);
                $user->setUpdatedAt($nowStr);
                $user->setPermission(1);
                $user->setIsDeleted(0);
                $user->save();
                // Envoi du mail :
                $to = $email; // this is your Email address
                $from = "Smart-Pix <no-reply@smart-pix.fr>"; // this is the sender's Email address
                $subject = "Votre inscription sur Smart-Pix !";
                $message = "<img src='http://smart-pix.fr/public/image/logo.png'>".
                    "<br>Bonjour ".$username.
                    "<br><br>Votre inscription sur Smart-Pix a bien été validée !
                    <br><br>Votre identifiant : ".$username.
                    "<br>Votre mot de passe : vous seul le connaissez !
                    <br><br>Cordialement,<br>L'équipe Smart-Pix"
                ;
                $headers = "From:" . $from . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($to,$subject,$message,$headers);
                $flash .= "<div class='flash flash-success'>Inscription terminée !</div>";
            }  if ($pwd != $confpwd) {
                $flash .= "<div class='flash flash-warning'>Les mots de passe sont différents</div>";
            }  if (!empty($usernameTaken)) {
                $flash .= "<div class='flash flash-warning'>Cet identifiant est déjà pris</div>";
            }  if (!empty($emailTaken)) {
                $flash .= "<div class='flash flash-warning'>Cet email existe déjà</div>";
            }
            $flash .= "</div>";
            echo $flash;
        }
        $v = new View('user.signup', 'frontend');
    }

    public function loginAction() {
        if ($_POST) {
            $flash = '<div class="flash-container">';
            $user = new User();
            $username = $_POST['username'];
            $password = $_POST['pwd'];
            $user = $user->populate(array('username' => $username));
            if (password_verify($password, $user->getPassword())) {
                if (!isset($_SESSION)) session_start();
                $_SESSION['username'] = $username;

                $_SESSION['user_id'] = $user->getId();
                header('Location: /');

            } else {
                $flash .= "<div class='flash flash-warning'>Erreur lors de la connexion</div>";
            }
            $flash .= "</div>";
            echo $flash;
        }
         $v = new View('user.login', 'frontend');
    }

    public function logoutAction() {
        session_unset();
        session_destroy();
        $v = new View('index', 'frontend');
    }

    public function forgetPasswordAction() {
        if ($_POST) {
            $flash = '<div class="flash-container">';
            $email = $_POST['email'];
            $emailExists = (new User())->getAllBy(['email' => $email]);
            if ($emailExists) {
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
                $to = $email;
                $from = "Smart-Pix <no-reply@smart-pix.fr>";
                $subject = "Mot de passe temporaire Smart-Pix";
                $message = "<img src='http://smart-pix.fr/public/image/logo.png'>".
                    "<br>Bonjour ".$user->getUsername().
                    "<br><br>Votre mot de passe temporaire : ".$tempPwd.
                    "<br><br>Cordialement,<br>L'équipe Smart-Pix"
                ;
                $headers = "From:" . $from . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($to,$subject,$message,$headers);
                $flash .= "<div class='flash flash-success'>Un email vous a été envoyé</div>";
            }
            $flash .= "</div>";
            echo $flash;
        }
        $v = new View('user.forgetPassword', 'frontend');
    }
}
