<!--
TODO
• Faire vérification avant l'envoi en js ou en php ?
• Ajouter une page et éditer son contenu (modifier )
• Apercu si pages spécifique séléctionné (A faire sur une autre page de type : /pages/nomDeLaPage)
• Gérer erreur plusieurs page de présentation ? (Afficher la dernière en date uniquement mais un message de warning quand même)
-->
<style>
    #albums li{
        background: red;
        color: #fff;
        cursor: pointer;
        border: 1px solid grey;
    }
    #albums li:hover{
        background: blue;
    }
    #albums li.active{
        background: blue;
    }
</style>
<div class="row" style="padding: 0 15px;">
    <div style="width: 100%;margin: 0 -15px;padding: 15px;">
        <input type="text" />
        <button type="button" name="ajouter" id="addPage">+</button>
    </div>
    <div style="width: 20%;" id="albums">
        <ul>
        <?php foreach ($albums as $album): ?>
            <li data-id="<?php echo $album['id'] ?>"><?php  echo $album['title']  ?>
        <?php endforeach ?>
        </ul>
    </div>
    <div style="width: 80%; background: red;">
        <form action="/album/addalbum" type="POST">
            <input type="hidden" name="id"/>
            Titre de la page : <input type="text" name="title" /><br>
            Est la page de présentation : <input type="checkbox" name="is_presentation" /><br>
            Est publié : <input type="checkbox" name="is_published" /><br>
            Description : <textarea name="description"></textarea>
            <button type="button" name="editAlbum">Editer</button>
        </form>
        <script>
        $('#addPage').click(function(){
            $pageTitle = $(this).prev().val();
            $.ajax({
                url : '/album/addAlbum',
                type: 'POST',
                dataType: 'json',
                data : { title: $pageTitle },
                success: function(data){
                    console.log(data);
                    $('#albums').append('<li data-id="'+data.id+'">'+data.title+'</li>');
                },
                error: function(error){
                    console.log(error.responseText)
                }
            });
        });

        $(document).on('click','#albums li',function(){
            $('#albums li').each(function(){
                $(this).removeClass('active');
            })
            $(this).addClass('active');
            $id = $(this).data('id');
            $.ajax({
                url : '/album/showEdit',
                type: 'POST',
                dataType: 'json',
                data: { id: $id },
                success: function(data){
                    $('[name="id"]').val(data.id);
                    $('[name="title"]').val(data.title);
                    if(data.is_presentation == 1){
                        $('[name="is_presentation"]').prop('checked', true);
                    } else {
                        $('[name="is_presentation"]').prop('checked', false);
                    }
                    if(data.is_published == 1){
                        $('[name="is_published"]').prop('checked', true);
                    } else {
                        $('[name="is_published"]').prop('checked', false);
                    }
                    $('[name="description"]').val(data.description)
                },
                error: function(error){
                    console.log(error.responseText)
                }
            });
        })

        $('[name="editAlbum"]').click(function(){
            $form = $(this).parent();
            $.ajax({
                url: '/album/editAlbum',
                type: 'POST',
                dataType: 'json',
                data: $form.serialize(),
                success: function(data){
                    console.log(data);
                    $('li.active').text(data.title);
                }
            });
        });
        </script>
    </div>

</div>
