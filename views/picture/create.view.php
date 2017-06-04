<h1>Ajouter une nouvelle image</h1>

<?php
/*
 * Pour faire un formulaire, on prépare toutes ses données dans $config,
 * puis on include "form.mod.php" qui génère le form
 */
$config = array(
    "options" => [
        "method" => "POST",
        "action" => "#",
        "enctype" => "multipart/form-data",
        "class" => "form-group",
        "id" => "form-subscribe",
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
            "value" => null,
            "required" => true
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