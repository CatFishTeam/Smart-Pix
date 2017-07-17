<?php
$config = array(
    "options" => [
        "method" => "POST",
        "action" => "/community/create",
        "class" => "form-group",
        "submit" => "Créer une communauté",
        "submitName" => "create-community",
        "submitType" => 'button',
    ],
    "struc" => [
        "name" => [
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
        var error = false;
        $('[name="name"]').on('change paste keyup', function(){
            $name = $(this).val();
            $.ajax({
                url: '/community/check-name',
                method: 'POST',
                data : {name: $name},
                dataType: 'json',
                success: function(data){
                    if(data != 'good'){
                        $('[name="name"]').css({'outline':'none','border':'1px solid red','box-shadow': '0px 0px 4px 0px red'});
                        error = true;
                    }else {
                        $('[name="name"]').css({'border':'1px solid lightgray','box-shadow':'none'});
                        error = false;
                    }
                }
            });
        });
        function checkError(){
            $('input[required="required"],textarea[required="required"]').each(function(){
                if($(this).val().length == 0){
                    console.log('Un champ est mal rempli');
                    return false;
                }
            })
            return true;
        }
        $('[name="create-community"]').click(function(){
            if(!error && checkError()){
                $('form').submit();
            } else {
                alert('Le formulaire n\'est pas correctement rempli')
            }
        });
    </script>
</div>
