<!DOCTYPE html>
<html>
    <head>
        <title>Bienvenue sur Smart-Pix</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo PATH_RELATIVE; ?>public/css/style.css" />
        <link rel="shortcut icon" type="image/ico" href="<?php echo PATH_RELATIVE; ?>public/image/logo.ico"/>
        <!-- FONT A CHANGER -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <header>
            <div class="container">
                <div class="row">
                    <section class="col-4">
                        <a href="<?php echo PATH_RELATIVE; ?>"><img src="<?php echo PATH_RELATIVE; ?>public/image/logo.png" alt="Smart-Pix Logo" class="logo"/></a>
                        <nav>
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input type="text" placeholder="Recherche par photo, catégorie, artiste..."/>
                        </nav>
                    </section>

                    <!--    Non connecté :      -->
                    <?php if(!isset($_SESSION['username'])): ?>
                        <a href="<?php echo PATH_RELATIVE; ?>user/login" class="btn-login">Connexion</a>
                        <a href="<?php echo PATH_RELATIVE; ?>user/signup" class="btn-signup">Inscription</a>
                    <!--    Connecté :          -->
                    <?php else: ?>
                        <a href="<?php echo PATH_RELATIVE; ?>user/wall" class="btn-login"><i class="fa fa-camera-retro" aria-hidden="true"></i> My wall</a>
                        <a href="<?php echo PATH_RELATIVE; ?>user" class="btn-login"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['username']; ?></a>
                        <a href="<?php echo PATH_RELATIVE; ?>user/logout" class="btn-login">Déconnexion</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <section class="body-container">
            <?php include $this->view.".view.php"; ?>
        </section>

        <footer>
            Smart-Pix © - 2017
        </footer>
    </body>
</html>
