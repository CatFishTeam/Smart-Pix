Most Used Tag
<div class="col-3 statsIndex">
    <a href="/<?php echo($_SESSION['community_slug']) ?>/admin/users"></a>
    <h2>Utilisateurs</h2>
    <p><i class="fa fa-users" aria-hidden="true"></i></p>
    <p><?php echo $countUsers ?></p>
</div>

<div class="col-3 statsIndex">
    <a href="/<?php echo($_SESSION['community_slug']) ?>/admin/medias"></a>
    <h2>Photos</h2>
    <p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
    <p><?php echo $countPictures ?></p>
</div>

<div class="col-3 statsIndex">
    <a href="/<?php echo($_SESSION['community_slug']) ?>/admin/albums"></a>
    <h2>Albums</h2>
    <p><i class="fa fa-folder-open" aria-hidden="true"></i></p>
    <p><?php echo $countAlbums ?></p>
</div>
