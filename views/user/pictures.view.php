<?php
    if (isset($user) && isset($pictures)):
?>

    <h1>Photos de <a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/user/<?php echo $user->getId(); ?>"><?php echo $user->getUsername(); ?></a></h1>

        <div class="row">
        <?php foreach ($pictures as $picture): ?>

            <div class="picture col-6 col-m-12">
                <a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/picture/<?php echo $picture['id']; ?>"><img src="/public/cdn/images/<?php echo $picture['url']; ?>" alt="<?php echo $picture['title']; ?>"></a><br>
                <h2><?php echo $picture['title']; ?></h2>
                <p><?php echo $picture['description']; ?></p>
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