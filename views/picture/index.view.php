<div class="row">
        <?php if (isset($picture) && !empty($picture)): ?>
            <div class="col-10 image-center">
                <!-- La photo ! -->
                <img src="<?php echo PATH_RELATIVE; ?>public/cdn/images/<?php echo $picture->getUrl(); ?>" alt="">
            </div>
            <div class="col-2 align-left">
                <!-- Info photo & photographe -->
                <h2><?php echo $picture->getTitle(); ?></h2>
                <h3 class="italic">Par <a href="<?php echo PATH_RELATIVE; ?>user/wall/<?php echo $author->getId(); ?>"><?php echo $author->getUsername(); ?></a></h3>
                <p><?php echo $picture->getDescription(); ?></p>
            </div>
            <div class="row">
                <h2>Commentaires :</h2>
                <?php if(isset($comments)){ ?>
                    <?php foreach ($comments as $comment): ?>
                        <p><?php echo $comment['content'] ?></p>
                    <?php endforeach ?>
                <?php } ?>
                <?php if(isset($unpublishedComments)){ ?>
                    <div class="col-12">
                        <p>Vous avez déjà un message en attente de validation sur cette photo</p>
                    </div>
                <?php } else { ?>
                    <div class="col-12">
                        <form action="/comment/add" method="post">
                            <input type="hidden" name="id" value="<?php echo $id[0] ?>" />
                            <textarea name="content"></textarea>
                            <button type="submit">Envoyer</button>
                        </form>
                    </div>
                <?php } ?>
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
