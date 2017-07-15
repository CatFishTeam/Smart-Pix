<?php
/*
 * Pour faire un formulaire, on prépare toutes ses données dans $config,
 * puis on include "form.mod.php" qui génère le form
 */
$config = array(
    "options" => [
        "method" => "POST",
        "action" => "",
        "class" => "form-group",
        "submit" => "Créer une communauté",
        "submitName" => "create-community",
    ],
    "struc" => [
        "title" => [
            "type" => "text",
            "placeholder" => "Nom de la communauté",
            "value" => null,
            "required" => true
        ],
        "description" => [
            "type" => "textarea",
            "placeholder" => "Description",
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
