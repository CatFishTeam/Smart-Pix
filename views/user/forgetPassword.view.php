<h1>Mot de passe oublié</h1>

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
        "submit" => "Demander un mot de passe temporaire",
        "submitName" => "forgetPassword"
    ],
    "struc" => [
        "email" => [
            "type" => "email",
            "placeholder" => "Votre email",
            "value" => (isset($_POST['email'])) ? $_POST['email'] : null,
            "required" => true
        ],
    ]
);

$this->includeModal("form", $config);

?>