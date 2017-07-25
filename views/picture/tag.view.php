<div class="row">
    <div class="col-12">
        <?php if (isset($tag) && $tag): ?>
        <h2>Images avec le tag « <?php echo $tag->getTitle(); ?> »</h2>
            <?php
            if (isset($tagPictures)):
            foreach ($tagPictures as $tagPicture):
                $picture = new Picture();
                $picture = $picture->populate(['id' => $tagPicture['picture_id']]);
            ?>
                <div class="picture col-6 col-m-12">
                    <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/picture/<?php echo $picture->getId(); ?>"><img src="/public/cdn/images/<?php echo $picture->getUrl(); ?>" alt="<?php echo $picture->getTitle(); ?>"></a><br>
                    <h2><?php echo $picture->getTitle(); ?></h2>
                    <p><?php echo $picture->getDescription(); ?></p>
                </div>
            <?php endforeach;
            endif; ?>
        <?php endif; ?>
    </div>
</div>