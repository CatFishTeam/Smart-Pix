<!--
TODO
• Message flash !!
• IS_PUBLISHED (voir controller)
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
    #images{
        position: absolute;
        top: 30%;
        left: 20%;
        width: 80%;
        background: green;
        border: 2px solid grey;
        padding: 15px;
        bottom: 0;
    }
    #images .image{
        width: 20%;
        position: relative;
        display: inline-block;
        margin: 10px;
    }
    #images .image img{
        width: 100%;
        object-fit: cover;
    }
    #images .image button{
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }
    #pictureNotIn img{
        cursor: pointer;
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
</style>
<div style="margin: -10px;position: relative;top: 0;left: 0;width: 100%;height: 100vh;">
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
    <div style="position: absolute; width: 20%; height: 45%; background: yellow; border: 2px solid grey; overflow-y: auto; top: 55%;" id="pictureNotIn">

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
        <div id="images">
        </div>
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
            $('[name="id"]').val(data.album.id);
            $('[name="title"]').val(data.album.title);
            if(data.album.is_presentation == 1){
                $('[name="is_presentation"]').prop('checked', true);
            } else {
                $('[name="is_presentation"]').prop('checked', false);
            }
            if(data.album.is_published == 1){
                $('[name="is_published"]').prop('checked', true);
            } else {
                $('[name="is_published"]').prop('checked', false);
            }
            $('[name="description"]').val(data.album.description);
            $('#images').empty();
            data.pictures.forEach(function(image){
                $('#images').append('<div class="image"><img src="/public/cdn/images/'+image.url+'"/><button class="delete" data-id="'+image.id+'"><i class="fa fa-times" aria-hidden="true"></i></button></div>');
            });
            $('#pictureNotIn').empty();
            Object.keys(data.picturesNotIn).map(function(objectKey, index) {
                var image = data.picturesNotIn[objectKey];
                $('#pictureNotIn').append('<img  data-id="'+image.id+'" style="max-width: 100%" src="/public/cdn/images/thumbnails/'+image.url+'"/>');
            });
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
            $('#images').append('<div class="image"><img src="/public/cdn/images/'+data.url+'"/><button class="delete" data-id="'+data.id+'"><i class="fa fa-times" aria-hidden="true"></i></button></div>');
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
