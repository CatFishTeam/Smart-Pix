<div class="row">
    <a href="/community/create" class="btn btn-login">Créer une communauté</a>
    <div class="col-12">
        <?php foreach($communities as $c): ?>
            <a href="<?php echo $c['slug']; ?>"><h3><?php echo $c['name']; ?></h3></a>
        <?php endforeach ?>
    </div>
</div>
