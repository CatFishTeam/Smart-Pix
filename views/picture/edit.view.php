<?php if (isset($picture) && !empty($picture) && $_SESSION['user_id'] == $picture->getUserId()): ?>
    <h1>Editer l'image : <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/picture/<?php echo $picture->getId(); ?>"><?php echo $picture->getTitle(); ?></a></h1>

    <?php
    /*
     * Pour faire un formulaire, on prépare toutes ses données dans $config,
     * puis on include "form.mod.php" qui génère le form
     */
    $config = array(
        "options" => [
            "method" => "POST",
            "action" => "#",
            "class" => "form-group",
            "submit" => "Editer mon image",
            "submitName" => "create-image",
        ],
        "struc" => [
            "title" => [
                "type" => "text",
                "placeholder" => "Nom de l'image",
                "value" => $picture->getTitle(),
            ],
            "description" => [
                "type" => "text",
                "placeholder" => "Description courte",
                "value" => $picture->getDescription(),
            ],
            "tags" => [
                "type" => "text",
                "placeholder" => "Tags (optionnel) : séparez vos tags par des virgules (exemple : chat, animal, maison)",
                "value" => null,
                "id" => "tags",
                "autocomplete" => "off"
            ],
        ]
    );
    ?>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <?php include "views/modals/form.mod.php"; ?>
        </div>
    </div>
    <div class="tags-res"><p></p></div>
    <?php if (isset($tagPicture) && !empty($tagPicture)): ?>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="picture-tags remove-tags">
                    <p>Tags de l'image : </p>
                    <p>
                        <?php
                        foreach ($tagPicture as $tagP):
                            $tag = new Tag();
                            $tag = $tag->populate(['id' => $tagP['tag_id']]);
                            ?>
                            <span>
                                <?php echo $tag->getTitle(); ?>
                                <span class="remove-tag" data-tag-id="<?php echo $tag->getId(); ?>" data-picture-id="<?php echo $picture->getId(); ?>">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                            </span>
                        <?php endforeach; ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p>L'image n'a pas été trouvée ou vous n'êtes pas autorisé à voir cette page.</p>
<?php endif; ?>

<script>
    $(document).ready(function () {
        /* Tags in input field : */
        var tags = $('#tags');
        var res = $('.tags-res p');
        var array = [];

        tags.css({
            color: "transparent",
            padding: "1px 0 0 21px"
        });
        res.css({
            position: "absolute",
            top: tags.position().top,
            left: tags.position().left + 15,
            margin: "4px 0",
            fontSize: "14px",
            height: "20px",
            lineHeight: "20px",
            display: "inline-block",
            borderRadius: "3px"
        });

        if (tags.val().trim() == "") {
            res.css("display", "none");
        }

        tags.on('input', function () {
            res.html("");
            array = tags.val().trim().split(",");

            $.each(array, function (i, value) {
                value = value.trim();
                res.append("<span>"+ value +"</span>");
            });
            if (tags.val().trim() == "") {
                res.css("display", "none");
            } else  {
                res.css("display", "inline-block");
            }
        });

        /* Tags to remove : */
        $('body').on('click', '.remove-tag', function () {
            $tag_id = $(this).data('tag-id');
            $picture_id = $(this).data('picture-id');
            var remove = confirm("Voulez-vous supprimer ce tag de l'image ?");
            if (remove) {
                $(this).parent().fadeOut("slow");
                $.ajax({
                    url: '/picture/remove-tag',
                    method: 'POST',
                    dataType: 'json',
                    data: {tag_id: $tag_id, picture_id: $picture_id},
                    success: function(data){
                        $('body').append(data);
                        flash();
                    },
                    error: function(error){
                        console.log(error.responseText);
                    }
                });
            }
//           alert("tag : " + $(this).data('tag-id') + " ; picture : " + $(this).data('picture-id'));
        });

    });
</script>
