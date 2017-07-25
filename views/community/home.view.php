<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="feed"><a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/feed"><i class="fa fa-rss-square" aria-hidden="true"></i> Flux RSS</a></p>
            <?php
            include __DIR__.'/../components/infiniteScroll.php';
            ?>
        </div>
    </div>
</div>

