<h1>Mot de passe oublié</h1>

<div class="row">
    <div class="col-4"></div>
    <div class="col-4">
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
    </div>
</div>
