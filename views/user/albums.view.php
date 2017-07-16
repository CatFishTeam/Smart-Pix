<?php
    if (isset($user) && isset($albums)):
?>

    <h1>Albums de <a href="/user/<?php echo $user->getId(); ?>"><?php echo $user->getUsername(); ?></a></h1>

        <div class="row">
        <?php foreach ($albums as $album): ?>

            <div class="picture col-6 col-m-12">
                <a href="/album/<?php echo $album['id']; ?>"><img src="/public/cdn/images/<?php echo $album['thumbnail_url']; ?>" alt="<?php echo $album['title']; ?>"></a><br>
                <h2><?php echo $album['title']; ?></h2>
                <p><?php echo $album['description']; ?></p>
            </div>

        <?php endforeach; ?>
        </div>
<?php
    else:
?>
    <p>Cet utilisateur n'existe pas.</p>
<?php
    endif;
?>