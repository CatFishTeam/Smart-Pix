<?php
class GuestController{
    public function signup(){
        require_once __DIR__ . '/../vendor/autoload.php';
        // Si le formulaire a été envoyé :
        $flash = '<div class="flash-container">';
        if (!empty($_POST['g-recaptcha-response'])) {
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

    public function activate($token) {
        $flash = '<div class="flash-container">';
        $user = new User();
        $user = $user->populate(array('access_token' => $token));

        if (!empty($user) && $user->getStatus() == 0) {
            $user->setStatus(1);
            $user->save();
            $username = $user->getUsername();
            $password = $user->getPassword();
            if (!isset($_SESSION)) session_start();
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['permission'] = $user->getPermission();
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

    public function forgetPassword() {
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
        $v = new View('user.forgetPassword', 'frontend');
    }
}
