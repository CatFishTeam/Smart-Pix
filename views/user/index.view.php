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
        "submit" => "Mettre à jour le profil"
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
            "required" => true
        ],
        "confpwd" => [
            "type" => "password",
            "placeholder" => "Confirmation le nouveau mot de passe",
            "value" => null,
            "required" => true
        ],
    ]
);

include "views/modals/form.mod.php";

echo "<h2>Informations personnelles</h2>";

$config = array(
    "options" => [
        "method" => "POST",
        "action" => "#",
        "class" => "form-group",
        "id" => "form-subscribe",
        "submit" => "Mettre à jour le profil"
    ],
    "struc" => [
        "firstname" => [
            "type" => "text",
            "placeholder" => "Votre prénom",
            "value" => $user->getFirstname(),
            "required" => true
        ],
        "lastname" => [
            "type" => "text",
            "placeholder" => "Votre nom",
            "value" => $user->getLastname(),
            "required" => true
        ],
        "avatar" => [
            "type" => "file",
            "placeholder" => "Ajouter un avatar",
            "value" => null,
            "required" => true
        ],
    ]
);

include "views/modals/form.mod.php";

?>