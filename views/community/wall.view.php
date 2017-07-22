<div class="row">
    <div class="col-4 col-m-12">
        <div class="bio">
            <div class="profil-avatar">
                <?php if (!empty($user->getAvatar())): ?>
                    <img src="/public/cdn/images/avatars/<?php echo $user->getAvatar(); ?>" alt="">
                <?php else: ?>
                    <p>Aucun avatar sélectionné</p>
                <?php
                endif;
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user->getId()):
                ?>
                <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/profile"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
                <?php endif; ?>
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
                <h2><a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/user-albums/<?php echo $user->getId(); ?>">Ses albums</a></h2>
                <p class="photos-fav">
                    <?php foreach ($albums as $album): ?>
                        <a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/album/<?php echo $album['id']; ?>"><img src="/public/cdn/images/<?php echo $album['thumbnail_url']; ?>" alt="<?php echo $album['title']; ?>"></a>
                        <?php
                    endforeach;
                    if (count($albums) == 0):
                        ?>
                        Aucun album à afficher.
                    <?php elseif (count($albums) == 14): ?>
                        <span><a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/user-albums/<?php echo $user->getId(); ?>" class="wall-more">...</a></span>
                    <?php endif; ?>
                </p>
                <h2><a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/user-pictures/<?php echo $user->getId(); ?>">Ses photos</a></h2>
                <p class="photos-fav">
                    <?php foreach ($pictures as $picture): ?>
                        <a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/picture/<?php echo $picture['id']; ?>"><img src="<?php echo PATH_RELATIVE; ?>public/cdn/images/<?php echo $picture['url']; ?>" alt="<?php echo $picture['title']; ?>"></a>
                        <?php
                    endforeach;
                    if (count($pictures) == 0):
                        ?>
                        Aucune photo à afficher.
                    <?php elseif (count($pictures) == 14): ?>
                        <span><a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/user-pictures/<?php echo $user->getId(); ?>" class="wall-more">...</a></span>
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
                        <a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/add-picture" class="btn-timeline-actions">Ajouter une image</a>
                        <a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/add-album" class="btn-timeline-actions">Ajouter un album</a>
                    </p>
                </div>
            <?php endif; ?>
            <div class="timeline-story">
                <?php
                if (count($actions) < 1): ?>
                <p class="no-action">Cet utilisateur n'a pas encore d'activités</p>
                <?php endif;
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

                                case "create-community":
                                    $commu = new Community();
                                    $commu = $commu->populate(['id' => $action['related_id']]); ?>
                                    <?php echo $user->getUsername(); ?> a créé une nouvelle communauté : <a href="/<?php echo $commu->getSlug(); ?>"><?php echo $commu->getName(); ?></a>
                                    <?php echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "join-community":
                                    $commu = new Community();
                                    $commu = $commu->populate(['id' => $action['related_id']]); ?>
                                    <?php echo $user->getUsername(); ?> a rejoint une communauté : <a href="/<?php echo $commu->getSlug(); ?>"><?php echo $commu->getName(); ?></a>
                                    <?php echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "picture":
                                    $picture = new Picture();
                                    $picture = $picture->populate(['id' => $action['related_id']]); ?>
                                    <?php echo $user->getUsername(); ?> a ajouté une nouvelle image : <a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/picture/<?php echo $action['related_id']; ?>"><?php echo $picture->getTitle(); ?></a>
                                    <?php echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "album":
                                    $album = new Album();
                                    $album = $album->populate(['id' => $action['related_id']]); ?>
                                    <?php echo $user->getUsername(); ?> a ajouté un nouvel album : <a href="/<?php echo isset($community) ? $community->getSlug() : ""; ?>/album/<?php echo $action['related_id']; ?>"><?php echo $album->getTitle(); ?></a>
                                    <?php echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
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

<script>
    function loadActions(actions, count, limit) {
        $.each(actions, function () {
            if (count >= limit)
                return false;
            $(this).fadeIn("slow");
            count++;
        });
    }
    $(document).ready(function() {
        var win = $(window);
        var actions = $('.story');
        var limit = 10;
        var count = 0;
        console.log(actions.length);
        actions.hide();
        loadActions(actions, count, limit);

        $('.loading').hide();

        win.scroll(function() {
            // Test si on a atteint le bas de page :
            if ($(document).height() - win.height() == Math.ceil(win.scrollTop())) {
                limit += 10;
                loadActions(actions, count, limit);
            }
        });
    });
</script>
