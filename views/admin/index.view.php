<div class="row">
    <div class="col-5 statsIndex">
        <a href="/<?php echo($_SESSION['community_slug']) ?>/admin/medias"></a>
        <h2>Photos</h2>
        <p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
        <p><?php echo $countPictures ?></p>
    </div>

    <div class="col-5 statsIndex">
        <a href="/<?php echo($_SESSION['community_slug']) ?>/admin/albums"></a>
        <h2>Albums</h2>
        <p><i class="fa fa-folder-open" aria-hidden="true"></i></p>
        <p><?php echo $countAlbums ?></p>
    </div>
</div>
<div class="row">
    <div>
        <?php if ($_SESSION['permission'] > 2): ?>
        <div class="col-5 statsIndex">
            <a href="/<?php echo($_SESSION['community_slug']) ?>/admin/users"></a>
            <h2>Utilisateurs</h2>
            <p><i class="fa fa-users" aria-hidden="true"></i></p>
            <p><?php echo $countUsers ?></p>
        </div>
    <?php endif; ?>
        <div class="col-5 statsIndex">
            <a href="/<?php echo($_SESSION['community_slug']) ?>/admin/comments"></a>
            <h2>Commentaires</h2>
            <p><i class="fa fa-commenting" aria-hidden="true"></i></p>
            <p><?php echo $countComments ?></p>
        </div>
    </div>
</div>
