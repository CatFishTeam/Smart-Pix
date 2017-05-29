<h1>Connexion</h1>

<?php
/*
 * Pour faire un formulaire, on prépare toutes ses données dans $config,
 * puis on include "form.mod.php" qui génère le form
 */
if (!$userConnected):
$config = array(
    "options" => [
        "method" => "POST",
        "action" => "#",
        "class" => "form-group",
        "id" => "form-subscribe",
        "submit" => "Se connecter",
        "submitName" => "login"
    ],
    "struc" => [
        "username" => [
            "type" => "text",
            "placeholder" => "Votre identifiant",
            "value" => null,
            "required" => true
        ],
        "pwd" => [
            "type" => "password",
            "placeholder" => "Votre mot de passe",
            "value" => null,
            "required" => true
        ]
    ]
);

include "views/modals/form.mod.php";

?>
    <p><a href="<?php echo PATH_RELATIVE."user/forgetPassword" ?>">Mot de passe oublié ?</a></p>
<?php else: ?>
    <h2>Vous êtes connecté !</h2>
<?php endif; ?>