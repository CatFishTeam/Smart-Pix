<div class='row'>
    <div class="col-6">
        <h2>Ajouter une photo</h2>
        <form method="post" id="fileinfo" name="fileinfo" class="form-group">
            <label>Choisir un fichier :</label><br>
            <input type="file" name="file">
            <input type="text" name="title" placeholder="Titre de la photo">
            <textarea name="description" placeholder="Description de la photo"></textarea>
            <input type="submit" value="Ajouter" />
        </form>
    </div>
    <div class="col-6" style="text-align: center;">
        <h2>Place restante sur votre communauté</h2>
        <div class="weight" style="height: 50px; background: grey; width: 300px; border-radius: 10px; margin: auto;">
            <div class="bar" data-octet="<?php isset($totalWeight) ? $totalWeight : '0' ?>" style="height: 50px; background: green; width: 0; border-radius: 10px; transition: ease 2s;"></div>
            <div class="percent"></div>
        </div>Il vous reste 5Go de libre
    </div>
</div>
<style>
    .imageContainer{
        display: inline-block;
        margin: 10px;
        overflow: hidden;
        width: 150px;
        height: 150px;
        border: 2px solid green;
    }
    .imageContainer img{
        width: 150px;
        height: 150px;
        object-fit: cover;
    }
</style>
<div class="row">
    <h2>Listing picture</h2>
    <div id='output'>
        <?php
        foreach($pictures as $picture): ?>
        <div class="imageContainer relative" style="<?php echo ($picture['is_visible'] == 0) ? 'border: 2px solid green;' : 'border: 2px solid orange; ' ?>">
            <a href="/<?php echo($_SESSION['community_slug']) ?>/picture/<?php echo $picture['id'] ?>"></a>
            <button class="delete" data-url="<?php echo $picture['url'] ?>"><i class="fa fa-times" aria-hidden="true"></i></button>
            <?php if($picture['is_visible'] == 0): ?>
                <button class="unPublish" data-url="<?php echo $picture['url'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></button>
            <?php else: ?>
                <button class="publish" data-url="<?php echo $picture['url'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></button>
            <?php endif ?>
            <img src="/public/cdn/images/<?php echo $picture['url'] ?>" alt="<?php echo $picture['title'] ?>">
        </div>
    <?php endforeach ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var percent = Math.round(($('.bar').data('octet') / 42949672960) * 100)+"%";

    // var 42949672960
    //Bar de niveau
    $('.bar').css('width',percent);
    $('.percent').text(percent);

    //Envoie de fichier
    $('#fileinfo').submit(function(e){
        if($('[name="file"]').get(0).files.length == 0){
            alert('Vous n\'avez pas uploadé de fichier');
            return false;
        }
        if($('[name="title"]').val() == ""){
            alert('Vous devez rentrer un Titre')
            return false;
        }

        $('#output').prepend('<div class="loader imageContainer relative"><img src="/public/image/loader.gif" style="width: 100%" /></div>');

        var fd = new FormData(document.getElementById("fileinfo"));
        $.ajax({
          url: "/<?php echo($_SESSION['community_slug']) ?>/admin/uploadMedia",
          type: "POST",
          data: fd,
          processData: false,  // tell jQuery not to process the data
          contentType: false,   // tell jQuery not to set contentType
          success: function(data){
              data = JSON.parse(data);
              console.log(data)
              $('#output').prepend('<div class="imageContainer relative"><a href="/<?php echo $_SESSION['community_slug'] ?>/picture/'+data.id+'"></a><button class="delete" data-url="'+data.url+'"><i class="fa fa-times" aria-hidden="true"></i></button><button class="publish" data-url="'+data.url+'"><i class="fa fa-eye" aria-hidden="true"></i></button><img src="/public/cdn/images/'+data.url+'" /></div>');
              $('.loader').remove();
              $('[name="file"]').val('');
              $('[name="title"]').val('');
              $('[name="description"]').val('');
          },
          error: function(error){
              console.log(error);
          }
      });

        return false;
    });
})

$(document).on('click','.delete',function(){
    var _ = $(this);
    var url = _.data('url');
    $.ajax({
      url: "/<?php echo($_SESSION['community_slug']) ?>/admin/deleteMedia",
      type: "POST",
      dataType: 'json',
      data: { url: url },
      success: function(data){
          $('body').append(data);
          flash();
          _.parent().fadeOut(300, function() {
              _.parent().remove();
          });
      }
    });
})
$(document).on('click','.unPublish',function(){
    var _ = $(this);
    var url = _.data('url');
    $.ajax({
      url: "/<?php echo($_SESSION['community_slug']) ?>/admin/unPublishMedia",
      type: "POST",
      dataType: 'json',
      data: { url: url },
      success: function(data){
          $('body').append(data);
          flash();
          _.parent().css('border','2px solid orange')
          _.parent().append('<button class="publish" data-url="'+url+'"><i class="fa fa-eye" aria-hidden="true"></i></button>');
          _.remove();
      }
    });
})
$(document).on('click','.publish',function(){
    var _ = $(this);
    var url = _.data('url');
    $.ajax({
      url: "/<?php echo($_SESSION['community_slug']) ?>/admin/publishMedia",
      type: "POST",
      dataType: 'json',
      data: { url: url },
      success: function(data){
          $('body').append(data);
          flash();
          _.parent().css('border','2px solid green')
          _.parent().append('<button class="unPublish" data-url="'+url+'"><i class="fa fa-eye" aria-hidden="true"></i></button>');
          _.remove();
      }
    });

})
 </script>
