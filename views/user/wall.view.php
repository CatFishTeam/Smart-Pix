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
                    <span>...</span>
                </p>
                <h2>Ses albums</h2>
                <p class="photos-fav">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <span>...</span>
                </p>
                <h2>Ses photos</h2>
                <p class="photos-fav">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <img src="http://placehold.it/50x40" alt="">
                    <span>...</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="timeline">
            <div class="timeline-actions">
                <p>
                    <a href="<?php echo PATH_RELATIVE; ?>picture/create" class="btn-timeline-actions">Ajouter une image</a>
                    <a href="<?php echo PATH_RELATIVE; ?>album/create" class="btn-timeline-actions">Ajouter un album</a>
                </p>
            </div>
            <div class="timeline-story">
                <div class="story">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid delectus eos, ex facere
                        inventore, labore, molestiae possimus provident quasi sapiente sed veritatis vero voluptates. Ad
                        aliquid eum quidem totam ut?</p>
                </div>
                <div class="story">
                    <p>Accusamus ad, architecto culpa cumque harum maiores natus nostrum numquam pariatur quos ratione
                        reiciendis similique temporibus ut voluptates. Ducimus ea eius enim eos ipsam modi nobis numquam
                        pariatur, quibusdam ut.</p>
                </div>
                <div class="story">
                    <p>Asperiores beatae cum, delectus deleniti eos impedit itaque minus nobis, nostrum pariatur
                        perspiciatis quia quidem quis ratione sed sequi similique ullam voluptates! Alias assumenda
                        doloremque est praesentium quo tempora tempore?</p>
                </div>
                <div class="story">
                    <p>Animi assumenda autem deserunt dignissimos dolorem, esse eum excepturi explicabo illum ipsam iste
                        iure laboriosam maxime necessitatibus quaerat quod, temporibus unde vel voluptas voluptatum! Ea
                        enim fuga illo laborum quibusdam.</p>
                </div>
                <div class="story">
                    <p>Impedit officiis quae vitae. Animi eaque eligendi, facere labore nihil odit porro praesentium
                        quibusdam quidem quos sapiente similique, suscipit voluptatibus. Eveniet excepturi iusto labore
                        nisi non omnis quos repellendus sint.</p>
                </div>
            </div>
        </div>
    </div>
</div>