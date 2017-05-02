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
            $user = new User();
            $username = $_POST['username'];
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $confpwd = $_POST['confpwd'];
            if ($pwd == $confpwd) {
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
                echo "<div class='flash flash-success'>Inscription terminée !</div>";
                // Envoi du mail :
                $to = $email; // this is your Email address
                $from = "admin@smart-pix.fr"; // this is the sender's Email address
                $subject = "Votre inscription sur Smart-Pix !";
                $message = "Bonjour ".$username.
                    "<br><br>Votre identifiant : ".$username.
                    "<br>Votre mot de passe : vous seul le connaissez !
                    <br><br>Cordialement,<br>L'équipe Smart-Pix"
                ;
                $headers = "From:" . $from;
                mail($to,$subject,$message,$headers);
            } else {
                echo "<div class='flash flash-warning'>Les mots de passe sont différents</div>";
            }
        }
        $v = new View('user.signup', 'frontend');
    }

    public function loginAction() {
        if ($_POST) {
            $user = new User();
            $username = $_POST['username'];
            $password = $_POST['pwd'];
            $user = $user->populate(array('username' => $username));
            if (password_verify($password, $user->getPassword())) {
                if (!isset($_SESSION)) session_start();
                $_SESSION['username'] = $username;
                echo "<div class='flash flash-success'>Vous êtes connecté !</div>";
            } else {
                echo "<div class='flash flash-warning'>Erreur lors de la connexion</div>";
            }
        }
        $v = new View('user.login', 'frontend');
    }

    public function logoutAction() {
        session_unset();
        session_destroy();
        $v = new View('index', 'frontend');
    }
}
