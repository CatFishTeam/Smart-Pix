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

include "views/modals/form.mod.php";

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
            "value" => null,
            "required" => false
        ],
    ]
);

include "views/modals/form.mod.php";

?>