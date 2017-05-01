<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="description de ma page" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/public/css/admin.css" />
    </head>
    <body class="relative">
        <header>

        </header>
        <nav id="navigator">
            <ul>
                <li><i class="fa fa-home" aria-hidden="true"></i>Acceuil
                <li><i class="fa fa-user" aria-hidden="true"></i>Profil
                <li><i class="fa fa-bar-chart" aria-hidden="true"></i>Stats
                <li><i class="fa fa-file-text" aria-hidden="true"></i>Pages
                <li><i class="fa fa-file-image-o" aria-hidden="true"></i>Medias
                <li><i class="fa fa-commenting" aria-hidden="true"></i>Commentaires
                <li><i class="fa fa-cogs" aria-hidden="true"></i>Reglages
            </ul>
        </nav>
        <div id="page">

        </div>
        <?php include $this->view.".view.php"; ?>
    </body>
</html>
