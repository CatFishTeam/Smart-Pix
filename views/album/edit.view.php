<?php if (isset($album) && !empty($album) && $_SESSION['user_id'] == $album->getUserId()): ?>
<h1>Editer l'album : <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/album/<?php echo $album->getId(); ?>"><?php echo $album->getTitle(); ?></a></h1>

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
        "submit" => "Editer mon album",
        "submitName" => "create-album",
    ],
    "struc" => [
        "title" => [
            "type" => "text",
            "placeholder" => "Nom de l'album",
            "value" => $album->getTitle(),
        ],
        "description" => [
            "type" => "text",
            "placeholder" => "Description courte",
            "value" => $album->getDescription(),
        ],
        "MAX_FILE_SIZE" => [
            "type" => "hidden",
            "value" => "5242880"
        ],
        "thumbnail_url" => [
            "type" => "file",
            "placeholder" => "Sélectionnez une image de couverture",
            "id" => "uploadImg",
            "value" => null,
        ],
        "thumbnail_label" => [
            "type" => "label",
            "for" => "uploadImg",
            "text" => "<i class=\"fa fa-upload\" aria-hidden=\"true\"></i> Choisir une image de couverture"
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
<?php else: ?>
    <p>L'album n'a pas été trouvé ou vous n'êtes pas autorisé à voir cette page.</p>
<?php endif; ?>