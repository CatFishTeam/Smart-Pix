<h1>Profil</h1>

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
        "id" => "form-subscribe",
        "submit" => "Mettre à jour le profil",
        "submitName" => "profil",
    ],
    "struc" => [
        "username" => [
            "type" => "text",
            "placeholder" => "Votre pseudo",
            "value" => $user->getUsername(),
            "required" => true
        ],
        "email" => [
            "type" => "email",
            "placeholder" => "Votre email",
            "value" => $user->getEmail(),
            "required" => true
        ],
        "pwd" => [
            "type" => "password",
            "placeholder" => "Modifier votre mot de passe",
            "value" => null,
            "required" => false
        ],
        "confpwd" => [
            "type" => "password",
            "placeholder" => "Confirmer le nouveau mot de passe",
            "value" => null,
            "required" => false
        ],
    ]
);
?>
<div class="row">
    <div class="col-3">

    </div>
    <div class="col-6">
        <?php
        include "views/modals/form.mod.php";
        ?>
    </div>

</div>
<?php
echo "<h2>Informations personnelles</h2>";

$config = array(
    "options" => [
        "method" => "POST",
        "action" => "#",
        "enctype" => "multipart/form-data",
        "class" => "form-group",
        "id" => "form-subscribe",
        "submit" => "Mettre à jour les informations personnelles",
        "submitName" => "infos"
    ],
    "struc" => [
        "firstname" => [
            "type" => "text",
            "placeholder" => "Votre prénom",
            "value" => $user->getFirstname(),
            "required" => false
        ],
        "lastname" => [
            "type" => "text",
            "placeholder" => "Votre nom",
            "value" => $user->getLastname(),
            "required" => false
        ],
        "MAX_FILE_SIZE" => [
            "type" => "hidden",
            "value" => "5242880"
        ],
        "avatar" => [
            "type" => "file",
            "placeholder" => "Ajouter un avatar",
            "id" => "uploadImg",
            "value" => null,
            "required" => false
        ],
        "avatar_label" => [
            "type" => "label",
            "for" => "uploadImg",
            "text" => "<i class=\"fa fa-upload\" aria-hidden=\"true\"></i> Choisir un avatar"
        ],
    ]
);
?>
<div class="row">
    <div class="col-3"></div>
    <div class="col-2 profil-avatar">

        <?php if (!empty($user->getAvatar())): ?>
            <img src="<?php echo PATH_RELATIVE; ?>public/cdn/images/avatars/<?php echo $user->getAvatar(); ?>" alt="">
        <?php else: ?>
            <p>Aucun avatar sélectionné</p>
        <?php endif; ?>

    </div>
    <div class="col-4">
        <?php
        include "views/modals/form.mod.php";
        ?>
    </div>

</div>







