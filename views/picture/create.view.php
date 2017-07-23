<h1>Ajouter une nouvelle image</h1>

<?php
/*
 * Pour faire un formulaire, on prépare toutes ses données dans $config,
 * puis on include "form.mod.php" qui génère le form
 */
$config = array(
    "options" => [
        "method" => "POST",
        "action" => "",
        "enctype" => "multipart/form-data",
        "class" => "form-group",
        "submit" => "Ajouter mon image",
        "submitName" => "create-picture",
    ],
    "struc" => [
        "title" => [
            "type" => "text",
            "placeholder" => "Titre de l'image",
            "value" => null,
            "required" => true
        ],
        "description" => [
            "type" => "text",
            "placeholder" => "Description courte",
            "value" => null,
            "required" => true
        ],
        "MAX_FILE_SIZE" => [
            "type" => "hidden",
            "value" => "5242880"
        ],
        "picture" => [
            "type" => "file",
            "placeholder" => "Sélectionnez votre image",
            "id" => "uploadImg",
            "value" => null,
            "required" => true
        ],
        "picture_label" => [
            "type" => "label",
            "for" => "uploadImg",
            "text" => "<i class=\"fa fa-upload\" aria-hidden=\"true\"></i> Sélectionnez votre image"
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
    <div class="col-2">

    </div>
    <div class="col-8">
        <?php include "views/modals/form.mod.php"; ?>
    </div>
</div>
<div class="tags-res"><p></p></div>
<script>
    $(document).ready(function () {
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

    });
</script>