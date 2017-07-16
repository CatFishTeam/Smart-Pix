<div class="row">
    <div class="col-12" style="background: red;">
        <?php foreach($communities as $c): ?>
            <h3><?php echo $communities->getName(); ?></h3>
            <a href="<?php echo $communities->slug ?>">
        <?php endforeach ?>
    </div>
    <a href="/community/create">Créer une communauté</a>
</div>
