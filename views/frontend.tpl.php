<!DOCTYPE html>
<html>
    <head>
        <title><?php echo isset($title) ? $title . " | Smart-Pix" : "Smart-Pix"; ?></title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo PATH_RELATIVE; ?>public/css/style.css" />
        <link rel="shortcut icon" type="image/ico" href="<?php echo PATH_RELATIVE; ?>public/image/logo.ico"/>
        <!-- FONT A CHANGER -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script
          src="https://code.jquery.com/jquery-3.2.1.min.js"
          integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
          crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="row">
                    <section class="col-8 col-m-12">
                        <a href="<?php echo isset($community) ? "/".$community->getSlug() : PATH_RELATIVE; ?>" class="logo-header">
                            <span class="community-header"><?php echo isset($community) ? $community->getName() : ""; ?></span>
                            <img src="<?php echo PATH_RELATIVE; ?>public/image/logo.png" alt="Smart-Pix Logo" class="logo"/>
                        </a>
                        <nav>
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input type="text" placeholder="Recherche par photo, catégorie, artiste..."/>
                        </nav>
                    </section>
                    <section class="col-4 col-m-12 m-center">
                        <!--    Non connecté :      -->
                        <?php if(!isset($_SESSION['username'])): ?>
                            <a href="/login" class="btn btn-login">Connexion</a>
                            <a href="/signup" class="btn btn-signup">Inscription</a>
                            <!--    Connecté :          -->
                        <?php else: ?>
                            <a href="/" class="btn" title="Smart-Pix - Accueil"><i class="fa fa-home" aria-hidden="true"></i></a>
                            <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/user/<?php echo $_SESSION['user_id']; ?>" class="btn btn-login"><i class="fa fa-camera-retro" aria-hidden="true"></i> <?php echo $_SESSION['username']; ?></a>
                            <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/profile" class="btn btn-login"><i class="fa fa-user" aria-hidden="true"></i> Profil</a>
                            <a href="/logout" class="btn"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </header>
        <section class="breadcrumbs">
            <p>
                <a href="/">Smart-Pix</a> »
                <?php if(isset($community)): ?>
                    <a href="/<?php echo $community->getSlug(); ?>"><?php echo $community->getName(); ?></a> »
                <?php endif; ?>

                <?php if(isset($album)): ?>
                    <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/album/<?php echo $album->getId(); ?>"><?php echo $album->getTitle(); ?></a>
                <?php endif; ?>

                <?php if(isset($picture)): ?>
                    <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/picture/<?php echo $picture->getId(); ?>"><?php echo $picture->getTitle(); ?></a>
                <?php endif; ?>

                <?php if(isset($user)): ?>
                    <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/user/<?php echo $user->getId(); ?>"><?php echo $user->getUsername(); ?></a>
                <?php endif; ?>

            </p>
        </section>
        <section class="body-container">
            <?php include $this->view.".view.php"; ?>
        </section>

        <footer>
            <p>
                Smart-Pix © - 2017
            </p>

           <script>
                $('.flash-cell').on('click',function(){
                    $(this).fadeOut();
                });
                // var $messages = $('.flash-cell');
                // var i=0;
                //
                // (function fadeFlashMessage($collection, index){
                //     $collection.eq(index).fadeIn(1000, function(){
                //         fadeFlashMessage($collection, index++);
                //     }).delay('4000').fadeOut();
                // })($messages, i);
                //TODO DELAY is not overridable + Test to set up this (just above)
                function flash(){
                    $('.flash-cell').each(function(){
                        $(this).delay('500').fadeIn().delay('4000').fadeOut();
                    });
                }
                $(document).ready(function() {
                    flash();
                });
            </script>
        </footer>

    </body>
</html>
