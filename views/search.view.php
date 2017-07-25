<div class="row">
    <div class="col-12">
        <h2>Résultats pour « <?php echo $search; ?> »</h2>
    </div>
</div>
<div class="row search-res">
    <div class="col-4">
        <h3>Communautés</h3>
        <?php if (count($resCommu) == 0): ?>
        <p>Pas de résultat pour cette recherche.</p>
        <?php
        else:
            foreach ($resCommu as $commu):
        ?>
        <p><a href="<?php echo "/".$commu['slug']; ?>"><?php echo $commu['name']; ?></a></p>
        <?php
            endforeach;
        endif;
        ?>
    </div>
    <div class="col-4">
        <h3>Images</h3>
        <?php if (count($resPicture) == 0): ?>
        <p>Pas de résultat pour cette recherche.</p>
        <?php
        else:
            foreach ($resPicture as $picture):
                $pictureCommu = new Community();
                $pictureCommu = $pictureCommu->populate(['id' => $picture['community_id']]);
        ?>
        <p><a href="<?php echo "/".$pictureCommu->getSlug(); ?>/picture/<?php echo $picture['id']; ?>"><?php echo $picture['title']; ?></a></p>
        <?php
            endforeach;
        endif;
        ?>
    </div>
    <div class="col-4">
        <h3>Utilisateurs</h3>
        <?php if (count($resUser)  == 0): ?>
        <p>Pas de résultat pour cette recherche.</p>
        <?php
        else:
            foreach ($resUser as $user):
        ?>
        <p><a href="/user/<?php echo $user['id']; ?>"><?php echo $user['username']; ?></a></p>
        <?php
            endforeach;
        endif;
        ?>
    </div>
</div>