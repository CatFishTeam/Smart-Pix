<h1>
    <?php echo $user->getUsername(); ?>
</h1>

<div class="row">
    <div class="col-2">
        <div class="bio">
            <div class="profil-avatar">
                <?php if (!empty($user->getAvatar())): ?>
                    <img src="<?php echo PATH_RELATIVE; ?>/public/cdn/images/avatars/<?php echo $user->getAvatar(); ?>" alt="">
                <?php else: ?>
                    <p>Aucun avatar sélectionné</p>
                <?php endif; ?>
                <a href="<?php echo PATH_RELATIVE; ?>user"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
            </div>
            <div class="bio-info">
                <p class="username"><?php echo $user->getUsername(); ?></p>
                <p class="name"><?php echo $user->getFirstname() ." ". $user->getLastname(); ?></p>
            </div>
            <hr>
            <div class="bio-other">
                <h2>Photos préférées</h2>
                <p class="photos-fav">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                </p>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="timeline">

        </div>
    </div>
</div>