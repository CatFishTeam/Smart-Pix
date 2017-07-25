<div id="pageAlbum">
    <div id="addPage">
        <h2>Ajouter un album</h2>
        <input name="title" type="text" placeholder="Nom de l'album"/>
        <textarea name="description" placeholder="Description de l'album"></textarea>
        <button type="button" name="ajouter">+</button>
    </div>
    <div id="albums">
        <h2>Sélectionner un album</h2>
        <ul style="list-style: none; margin: 0; padding: 0;">
            <?php foreach ($albums as $album): ?>
                <li data-id="<?php echo $album['id'] ?>"><?php  echo $album['title']  ?>
            <?php endforeach ?>
        </ul>
    </div>
    <div id="editAlbum">
        <h2>Editer un album</h2>
        <form action="/album/addalbum" type="POST">
            <input type="hidden" name="id"/>
            Titre de la page : <input type="text" name="title" /><br>
            Est publié : <input type="checkbox" name="is_published" /><br>
            Description : <textarea name="description" placeholder="Description de l'album"></textarea>
            <button type="button" name="editAlbum">Editer</button>
            <button type="button" name="deleteAlbum">Supprimer</button>
            <button class="seeAlbum">Voir l'album</button>
        </form>
    </div>
    <div id="addPicture">
        <h2>Ajouter une photo</h2>
        <div id="pictureNotIn">

        </div>
    </div>
    <div id="images">
        <h2>Images de l'album</h2>
        <div id="pictureIn">

        </div>
    </div>
</div>
<script>
$('#addPage button').click(function(){
    $.ajax({
        url : '/<?php echo($_SESSION['community_slug']) ?>/admin/addAlbum',
        type: 'POST',
        dataType: 'json',
        data : { title: $('#addPage [name="title"]').val(), description: $('#addPage [name="description"]').val() },
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
            $('[name="id"]').val(data.album.id);
            $('#editAlbum [name="title"]').val(data.album.title);
            if(data.album.is_published == 1){
                $('[name="is_published"]').prop('checked', true);
            } else {
                $('[name="is_published"]').prop('checked', false);
            }
            $('[name="description"]').val(data.album.description);
            $('#pictureIn').empty();
            data.pictures.forEach(function(image){
                $('#pictureIn').append('<div class="image"><img src="/public/cdn/images/'+image.url+'"/><button class="delete" data-id="'+image.id+'"><i class="fa fa-times" aria-hidden="true"></i></button><button class="cover" data-id="'+image.id+'"><i class="fa fa-picture-o" aria-hidden="true"></i></button></div>');
            });
            $('#pictureNotIn').empty();
            Object.keys(data.picturesNotIn).map(function(objectKey, index) {
                var image = data.picturesNotIn[objectKey];
                $('#pictureNotIn').append('<img  data-id="'+image.id+'" style="max-width: 100%" src="/public/cdn/images/'+image.url+'"/>');
            });
            $('.seeAlbum').html('<a href="/<?php echo($_SESSION['community_slug']) ?>/album/'+data.album.id+'">Voir L\'album</a>');
        },
        error: function(error){
            console.log(error.responseText)
        }
    });
});

$(document).on('click','#pictureNotIn img',function(){
    $this = $(this);
    $id = $(this).data('id');
    $.ajax({
        url: '/<?php echo($_SESSION['community_slug']) ?>/admin/addPictureToAlbum',
        type: 'POST',
        dataType: 'json',
        data: {picture_id: $id, album_id: $('[name="id"]').val()},
        success: function(data){
            $this.fadeOut(function(){ $(this).remove(); });
            $('#pictureIn').append('<div class="image"><img src="/public/cdn/images/'+data.url+'"/><button class="delete" data-id="'+data.id+'"><i class="fa fa-times" aria-hidden="true"></i></button><button class="cover" data-id="'+data.id+'"><i class="fa fa-picture-o" aria-hidden="true"></i></button></div>');
        }
    })
});

$(document).on('click','.delete', function(){
    $this = $(this);
    $id = $(this).data('id');
    $('#pictureNotIn').prepend('<img  data-id="'+$id+'" style="max-width: 100%" src="'+$(this).prev().attr('src')+'"/>');
    $.ajax({
        url: '/<?php echo($_SESSION['community_slug']) ?>/admin/removePictureFromAlbum',
        type: 'POST',
        dataType: 'json',
        data: {id: $id},
        success: function(data){
            $('body').append(data);
            flash();
            $this.parents('.image').fadeOut(function(){
                $(this).remove()
            });
        }
    });
});
$(document).on('click','.cover', function(){
    $this = $(this);
    $id = $(this).data('id');
    // $('#pictureNotIn').prepend('<img  data-id="'+$id+'" style="max-width: 100%" src="'+$(this).prev().attr('src')+'"/>');
    $.ajax({
        url: '/<?php echo($_SESSION['community_slug']) ?>/admin/setPictureAsCover',
        type: 'POST',
        dataType: 'json',
        data: {id: $id, album_id: $('[name="id"]').val()},
        success: function(data){
            $('body').append(data);
            flash();
            $this.parents('.image').css('border','1px solid orange');

        }
    });
});

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
            $('[name="is_published"]').prop('checked', false);
            $('[name="description"]').val("");
        }
    });
})
</script>
