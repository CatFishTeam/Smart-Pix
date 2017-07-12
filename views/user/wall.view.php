<div class="row">
    <div class="col-4 col-m-12">
        <div class="bio">
            <div class="profil-avatar">
                <?php if (!empty($user->getAvatar())): ?>
                    <img src="<?php echo PATH_RELATIVE; ?>public/cdn/images/avatars/<?php echo $user->getAvatar(); ?>" alt="">
                <?php else: ?>
                    <p>Aucun avatar sélectionné</p>
                <?php endif; ?>
                <a href="<?php echo PATH_RELATIVE; ?>profile"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
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
                    <?php foreach ($albums as $album): ?>
                        <a href="<?php echo PATH_RELATIVE; ?>album/<?php echo $album['id']; ?>"><img src="<?php echo PATH_RELATIVE; ?>public/cdn/images/<?php echo $album['thumbnail_url']; ?>" alt="<?php echo $album['title']; ?>"></a>
                    <?php
                        endforeach;
                        if (count($albums) == 0):
                    ?>
                        Aucun album à afficher.
                    <?php elseif (count($albums) == 14): ?>
                        <span><a href="<?php echo PATH_RELATIVE; ?>user/albums/<?php echo $user->getId(); ?>" class="wall-more">...</a></span>
                    <?php endif; ?>
                </p>
                <h2>Ses photos</h2>
                <p class="photos-fav">
                    <?php foreach ($pictures as $picture): ?>
                        <a href="<?php echo PATH_RELATIVE; ?>picture/<?php echo $picture['id']; ?>"><img src="<?php echo PATH_RELATIVE; ?>public/cdn/images/<?php echo $picture['url']; ?>" alt="<?php echo $picture['title']; ?>"></a>
                    <?php
                        endforeach;
                        if (count($pictures) == 0):
                    ?>
                    Aucune photo à afficher.
                    <?php elseif (count($pictures) == 14): ?>
                        <span><a href="<?php echo PATH_RELATIVE; ?>user/pictures/<?php echo $user->getId(); ?>" class="wall-more">...</a></span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-8 col-m-12">
        <div class="timeline">
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user->getId()): ?>
            <div class="timeline-actions">
                <p>
                    <a href="<?php echo PATH_RELATIVE; ?>add-picture" class="btn-timeline-actions">Ajouter une image</a>
                    <a href="<?php echo PATH_RELATIVE; ?>add-album" class="btn-timeline-actions">Ajouter un album</a>
                </p>
            </div>
            <?php endif; ?>
            <div class="timeline-story">
                <?php
                    foreach ($actions as $action):
                        $action_date = strtotime($action['created_at']);
                ?>
                <div class="story">
                    <p>
                        <?php
                            switch ($action['type_action']) {
                                case "signup":
                                    $signUp = new User();
                                    $signUp = $signUp->populate(['id' => $action['related_id']]);
                                    echo $signUp->getUsername() . " a rejoint Smart-Pix. Bienvenue !";
                                    echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "picture":
                                    $picture = new Picture();
                                    $picture = $picture->populate(['id' => $action['related_id']]);
                                    echo $user->getUsername() . " a ajouté une nouvelle image : <a href=\"".PATH_RELATIVE."picture/".$action['related_id']."\">".$picture->getTitle()."</a>";
                                    echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "album":
                                    $album = new Album();
                                    $album = $album->populate(['id' => $action['related_id']]);
                                    echo $user->getUsername() . " a ajouté un nouvel album : <a href=\"".PATH_RELATIVE."album/".$action['related_id']."\">".$album->getTitle()."</a>";
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
