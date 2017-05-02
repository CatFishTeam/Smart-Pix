<h1>Connexion</h1>

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
        "submit" => "Se connecter"
    ],
    "struc" => [
        "username" => [
            "type" => "text",
            "placeholder" => "Votre pseudo",
            "required" => 0
        ],
        "pwd" => [
            "type" => "password",
            "placeholder" => "Votre mot de passe",
            "required" => 0
        ]
    ]
);

include "views/modals/form.mod.php";

?>
