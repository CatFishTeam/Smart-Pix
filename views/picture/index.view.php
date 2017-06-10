<div class="row">
        <?php if (isset($picture) && !empty($picture)): ?>
            <div class="col-10 image-center">
                <!-- La photo ! -->
                <img src="<?php echo PATH_RELATIVE; ?>public/cdn/images/<?php echo $picture->getUrl(); ?>" alt="">
            </div>
            <div class="col-2 align-left">
                <!-- Info photo & photographe -->
                <h2><?php echo $picture->getTitle(); ?></h2>
                <h3 class="italic">Par <?php echo $author->getUsername(); ?></h3>
                <p><?php echo $picture->getDescription(); ?></p>
            </div>
        <?php elseif (isset($picture) && empty($picture)): ?>
            <div class="col-12">
                <p>Cette image n'existe pas.</p>
            </div>
        <?php else: ?>
            <div class="col-12">
                <p>Listing des images</p>
            </div>
        <?php endif; ?>

</div>