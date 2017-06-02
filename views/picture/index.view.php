<div class="row">
    <div class="col-5">
        <!-- La photo ! -->
        <?php if (isset($picture) && !empty($picture)): ?>
            <img src="<?php echo PATH_RELATIVE; ?>/public/cdn/images/<?php echo $picture->getUrl(); ?>" alt="">
        <?php elseif (isset($picture) && empty($picture)): ?>
            <p>Cette image n'existe pas.</p>
        <?php else: ?>
            <p>Listing des images</p>
        <?php endif; ?>
    </div>

    <div class="col-1">
        <!-- Info photo & photographe -->
    </div>
</div>