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

        <!-- Pour afficher le css et js specific a certaines pages -->
        <!-- TODO
        • Set active or not
        • Link faire toute la taille !!
        -->
        <?php echo (isset($specificHeader) ? $specificHeader : '') ?>
    </head>
    <body>
        <script>
        function flash(){
            $('.flash-cell').each(function(){
                $(this).delay('500').fadeIn().delay('4000').fadeOut();
            });
        }
        </script>
        <noscript><strong>Attention !</strong> Ce site à besoin de Javascript pour fonctionner et il ne semble pas activé sur votre navigateur.</noscript>
        <nav id="navigator" style="display: none;">
            <ul>
                <li><a href="/"><img src="/image/logo.png" style="max-width: 50px;margin-top: 10px;margin-left: -10px;"/><span>Smart-Pix</span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin"><i class="fa fa-home" aria-hidden="true"></i><span>Acceuil</span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/albums"><i class="fa fa-file-text" aria-hidden="true"></i><span>Albums</span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/medias"><i class="fa fa-file-image-o" aria-hidden="true"></i><span>Medias</span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/comments"><i class="fa fa-commenting" aria-hidden="true"></i><span>Commentaires</span></a>
                <?php if($_SESSION['permission'] > 2): ?>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/stats"><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Stats</span></a>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/users"><i class="fa fa-users" aria-hidden="true"></i><span>Utilisateurs</span></a>
                <?php endif ?>
                <?php if($_SESSION['permission'] > 3): ?>
                <li><a href="/<?php echo($_SESSION['community_slug']) ?>/admin/settings"><i class="fa fa-cogs" aria-hidden="true"></i><span>Reglages</span></a>
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
</html>
