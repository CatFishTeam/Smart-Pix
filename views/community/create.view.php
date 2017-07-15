<?php
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
    <h1>Créez votre première communauté</h1>
    <div class="col-2">

    </div>
    <div class="col-8">
        <?php include "views/modals/form.mod.php"; ?>
    </div>
    <script>
        $('[name="title"]').on('change paste keyup', function(){
            $name = $(this).val();
            $.ajax({
                url: '/community/check-name',
                method: 'POST',
                data : {name: $name},
                dataType: 'json',
                success: function(data){
                    if(data == 'good'){

                    }
                }
            });
        });
    </script>
</div>
