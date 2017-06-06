<div class="row">
    <div class="col-4 col-m-12">
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
    <div class="col-8 col-m-12">
        <div class="timeline">
            <div class="timeline-actions">
                <p>
                    <a href="<?php echo PATH_RELATIVE; ?>picture/create" class="btn-timeline-actions">Ajouter une image</a>
                    <a href="<?php echo PATH_RELATIVE; ?>album/create" class="btn-timeline-actions">Ajouter un album</a>
                </p>
            </div>
            <div class="timeline-story">
                <?php
//                    var_dump($actions);
                    foreach ($actions as $action):
                        $action_date = strtotime($action['created_at']);
                ?>
                <div class="story">
                    <p>
                        <?php
                            switch ($action['type_action']) {
                                case "picture":
                                    echo $user->getUsername() . " a ajouté une <a href=\"".PATH_RELATIVE."picture/".$action['related_id']."\">nouvelle image</a> !";
                                    echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;
                                default:
                                    break;
                            }
                        ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>