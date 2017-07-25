<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="description de ma page" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/public/css/admin.css" />

        <script
          src="https://code.jquery.com/jquery-3.2.1.min.js"
          integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
          crossorigin="anonymous"></script>

        <?php echo (isset($specificHeader) ? $specificHeader : '') ?>
    </head>
    <body>
        <noscript><strong>Attention !</strong> Ce site à besoin de Javascript pour fonctionner et il ne semble pas activé sur votre navigateur.</noscript>
        <nav id="navigator">
            <ul>
                <li><a href="/<?php echo $_SESSION['community_slug']; ?>"><img src="/public/image/logo.png" style="max-width: 50px;margin-top: 10px;margin-left: -10px;"/><span><?php echo $_SESSION['community_name']; ?></span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin"><i class="fa fa-home" aria-hidden="true"></i><span>Accueil</span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/albums"><i class="fa fa-folder-open" aria-hidden="true"></i><span>Albums</span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/medias"><i class="fa fa-picture-o" aria-hidden="true"></i><span>Medias</span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/comments"><i class="fa fa-commenting" aria-hidden="true"></i><span>Commentaires</span></a>
                <?php if($_SESSION['permission'] > 2): ?>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/users"><i class="fa fa-users" aria-hidden="true"></i><span>Membres</span></a>
                <?php endif ?>
            </ul>
        </nav>
        <div id="mainContent">
            <?php include $this->view.".view.php"; ?>
        </div>
    </body>
    <footer>
        <script>
            //TODO Fix multiple messages stack
             $('.flash-cell').on('click',function(){
                 $(this).fadeOut();
             });
             function flash(){
                 $('.flash-cell').each(function(){
                     $(this).delay('500').fadeIn().delay('4000').fadeOut(function(){
                         $(this).remove();
                     });
                 });
             }
             $(document).ready(function() {
                 flash();
             });
         </script>
    </footer>
</html>
