<div class="row">
        <?php if (isset($picture) && !empty($picture)): ?>
            <div class="col-9 col-m-12 image-center">
                <!-- La photo ! -->
                <img src="/public/cdn/images/<?php echo $picture->getUrl(); ?>" alt="">
            </div>
            <div class="col-3 col-m-12 align-left picture-info-panel">
                <!-- Info photo & photographe -->
                <h2><?php echo $picture->getTitle(); ?></h2>
                <h3 class="italic">Par <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/user/<?php echo $author->getId(); ?>"><?php echo $author->getUsername(); ?></a></h3>
                <p><?php echo $picture->getDescription(); ?></p>
                    <?php if (isset($tagsId) && !empty($tagsId)): ?>
                        <hr>
                        <p class="picture-tags">
                            Tags :
                            <?php
                        foreach ($tagsId as $tagId):
                            $tag = new Tag();
                            $tag = $tag->populate(['id' => $tagId['tag_id']]);
                    ?>
                    <span><a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/tag/<?php echo $tag->getId(); ?>/<?php echo $tag->getSlug(); ?>"><?php echo $tag->getTitle(); ?></span></a>
                    <?php endforeach; ?>
                </p>
                <?php endif; ?>
            </div>
</div>
<?php //var_dump($albums); ?>
<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <p>
        <?php if (count($albums) > 1):
            echo "Cette image fait partie des albums suivants :";
        elseif (count($albums) == 1):
            echo "Cette image fait partie de l'album :";
        else:
            echo "Cette image ne fait partie d'aucun album.";
        endif; ?>

        <?php
        $i = 1;
        foreach ($albums as $album): ?>
            <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/album/<?php echo $album['id']; ?>"><?php echo $album['title']; ?></a>
            <?php
            if ($i != count($albums)) echo "- ";
            $i++;
            ?>
        <?php endforeach; ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <h2>Commentaires :</h2>
        <?php if(isset($comments)):
            foreach ($comments as $comment):
                $createdAt = strtotime($comment['created_at']);
                $commentAuthor = new User();
                $commentAuthor = $commentAuthor->populate(['id' => $comment['user_id']]);
                ?>

                <div class="comment">
                    <p class="comment-author">
                        <?php if (!empty($commentAuthor->getAvatar())): ?>
                            <img src="/public/cdn/images/avatars/<?php echo $commentAuthor->getAvatar(); ?>" class="comment-avatar" alt="Avatar de <?php echo $commentAuthor->getUsername(); ?>">
                        <?php else: ?>
                            <i class="fa fa-user comment-no-avatar" aria-hidden="true"></i>
                        <?php endif; ?>
                        <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/user/<?php echo $commentAuthor->getId(); ?>"><?php echo $commentAuthor->getUsername(); ?></a>
                    </p>
                    <p class="comment-time">le <?php echo date("d/m/Y", $createdAt); ?> à <?php echo date("G:i:s", $createdAt); ?></p>
                    <p class="comment-content"><?php echo $comment['content']; ?></p>
                </div>
            <?php endforeach ?>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <?php if(isset($unpublishedComments)): ?>
        <div class="col-12">
            <p>Vous avez déjà un message en attente de validation sur cette photo</p>
        </div>
    <?php else: ?>
        <div class="col-2"></div>
        <div class="col-8">
            <form action="/add-comment" method="post" class="form-group">
                <input type="hidden" name="id" value="<?php echo $id ?>" />
                <textarea name="content" required="required"></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    <?php endif; ?>

<?php elseif (isset($picture) && empty($picture)): ?>
<div class="col-12">
    <p>Cette image n'existe pas.</p>
</div>
<?php else: ?>
    <h2>Toutes les images</h2>
    <?php foreach ($allPictures as $picture): ?>

        <div class="picture col-6 col-m-12">
            <a href="/picture/<?php echo $picture['id']; ?>"><img src="/public/cdn/images/<?php echo $picture['url']; ?>" alt="<?php echo $picture['title']; ?>"></a><br>
            <h2><?php echo $picture['title']; ?></h2>
            <p><?php echo $picture['description']; ?></p>
        </div>

    <?php endforeach; ?>
<?php endif; ?>
</div>
