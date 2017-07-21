<!--
TODO
• Message flash !!
• IS_PUBLISHED (voir controller)
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
<div style="width: 100%; height: 10%; padding: 15px; background: mauve; border: 2px solid grey;
">
    <input type="text" />
    <button type="button" name="ajouter" id="addPage">+</button>
</div>
<div style="position: absolute; width: 20%; height: 45%; background: red; border: 2px solid grey; overflow-y: auto;" id="albums">
    <ul style="list-style: none; margin: 0; padding: 0;">
        <?php foreach ($albums as $album): ?>
            <li data-id="<?php echo $album['id'] ?>"><?php  echo $album['title']  ?>
        <?php endforeach ?>
    </ul>
</div>
<div style="position: absolute; width: 20%; height: 45%; background: yellow; border: 2px solid grey; overflow-y: auto; top: 55%;" id="albums">
    <ul style="list-style: none; margin: 0; padding: 0;">
        <?php foreach ($pictures as $picture): ?>
            <li data-id="<?php echo $picture['id'] ?>"><img style="height: 50px;" src="/public/cdn/images/thumbnails/<?php echo $picture['url'] ?>"/><p><?php echo $picture['title'] ?></p><br>
        <?php endforeach ?>
    </ul>
</div>
<div style="position: absolute; left: 20%; width: 80%; height: 20%; background: blue; color: #fff; border: 2px solid grey; padding: 15px;">
    <form action="/album/addalbum" type="POST">
        <input type="hidden" name="id"/>
        Titre de la page : <input type="text" name="title" /><br>
        Est la page de présentation : <input type="checkbox" name="is_presentation" /><br>
        Est publié : <input type="checkbox" name="is_published" /><br>
        Description : <textarea name="description"></textarea>
        <button type="button" name="editAlbum">Editer</button>
        <button type="button" name="deleteAlbum">Supprimer</button>
    </form>
</div>
<div style="position: absolute; top: 30%; left: 20%; width: 80%; background: green; border: 2px solid grey; padding: 15px; bottom: 0;">
    Disposition medias ?
</div>
<script>
$('#addPage').click(function(){
    $pageTitle = $(this).prev().val();
    $.ajax({
        url : '/<?php echo($_SESSION['community_slug']) ?>/admin/addAlbum',
        type: 'POST',
        dataType: 'json',
        data : { title: $pageTitle },
        success: function(data){
            console.log(data);
            $('#albums ul').append('<li data-id="'+data.id+'">'+data.title+'</li>');
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
        url : '/<?php echo($_SESSION['community_slug']) ?>/admin/getAlbum',
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
        url: '/<?php echo($_SESSION['community_slug']) ?>/admin/editAlbum',
        type: 'POST',
        dataType: 'json',
        data: $form.serialize(),
        success: function(data){
            $('li.active').text(data.title);
        }
    });
});


$('[name="deleteAlbum"]').click(function(){
    $id = $(this).parent().find('[name="id"]').val();
    $.ajax({
        url: '/<?php echo($_SESSION['community_slug']) ?>/admin/deleteAlbum',
        type: 'POST',
        dataType: 'json',
        data: {id: $id},
        success: function(data){
            $('li.active').remove();
            $('[name="title"]').val("");
            $('[name="is_presentation"]').prop('checked', false);
            $('[name="is_published"]').prop('checked', false);
            $('[name="description"]').val("");
        }
    });
})
</script>
