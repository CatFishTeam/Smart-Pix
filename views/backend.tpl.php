<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="description de ma page" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo PATH_RELATIVE; ?>public/css/admin.css" />
        <!-- Pour afficher le css et js specific a certaines pages -->
        <?php echo (isset($specificHeader) ? $specificHeader : '') ?>
    </head>
    <body>
        <div class="flexContainer">
            <header id="topBack">
                Ceci est notre header
            </header>
        </div>
        <div class="flexContainer">
            <nav id="navigator">
                <ul>
                    <li><a href="<?php echo PATH_RELATIVE; ?>admin"><i class="fa fa-home" aria-hidden="true"></i>Acceuil</a>
                    <li><a href="<?php echo PATH_RELATIVE; ?>admin/profil"><i class="fa fa-user" aria-hidden="true"></i>Profil</a>
                    <li><a href="<?php echo PATH_RELATIVE; ?>admin/stats"><i class="fa fa-bar-chart" aria-hidden="true"></i>Stats</a>
                    <li><a href="<?php echo PATH_RELATIVE; ?>admin/pages"><i class="fa fa-file-text" aria-hidden="true"></i>Pages</a>
                    <li><a href="<?php echo PATH_RELATIVE; ?>admin/medias"><i class="fa fa-file-image-o" aria-hidden="true"></i>Medias</a>
                    <li><a href="<?php echo PATH_RELATIVE; ?>admin/comments"><i class="fa fa-commenting" aria-hidden="true"></i>Commentaires</a>
                    <li><a href="<?php echo PATH_RELATIVE; ?>admin/settings"><i class="fa fa-cogs" aria-hidden="true"></i>Reglages</a>
                </ul>
            </nav>
            <div id="page">
                <?php include $this->view.".view.php"; ?>
            </div>
        </div>
    </body>
</html>
