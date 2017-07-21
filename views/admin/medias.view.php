<h1>On affiche : </h1>
    <!-- TODO
    • Editer un media
    • Mettre en PAGE
-->

• Valider les images des utilisateurs ?

<form method="post" id="fileinfo" name="fileinfo">
    <label>Choisir un fichier :</label><br>
    <input type="file" name="file">
    Title : <input type="text" name="title">
    Description : <textarea name="description"></textarea>
    <input type="submit" value="Upload" />
</form>

<div class="weight" style="height: 50px; background: grey; width: 300px; border-radius: 10px;">
    <div class="bar" data-octet="<?php isset($totalWeight) ? $totalWeight : '0' ?>" style="height: 50px; background: green; width: 0; border-radius: 10px; transition: ease 2s;"></div>
    <div class="percent"></div>
</div>Il vous reste 5Go de libre
<div id='output'>
    <?php
        foreach($pictures as $picture): ?>
        <div class="imageContainer relative">
            <a href="/picture/<?php echo $picture['id'] ?>"></a>
            <button class="delete" data-url="<?php echo $picture['url'] ?>"><i class="fa fa-times" aria-hidden="true"></i></button>
            <img src="/public/cdn/images/thumbnails/<?php echo $picture['url'] ?>" alt="<?php echo $picture['title'] ?>">
        </div>
    <?php endforeach ?>
</div>
<div id="server-response"><!-- Json response from server --></div>

<!-- <h1>Ajax Image Upload with PHP ImageMagick</h1>
<div class="upload-wrapper">
<div class="upload-click">Click here to Upload File</div>
<div class="upload-image" style="display:none"><img src="images/ajax-loader.gif" width="16" height="16"></div>
<input type="file" id="input-file-upload" style="display:none" />
</div>
<div id="server-response"><!-- Json response from server --></div>


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
              console.log(data);
            //   data = JSON.parse(data);
            //   console.log(data.msg);
            //   $('#output').prepend('<div class="imageContainer relative"><a href="/picture'+data.id+'"></a><button class="delete" data-url="'+data.img+'"><i class="fa fa-times" aria-hidden="true"></i></button><img src="/public/cdn/images/thumbnails/'+data.img+'" /></div>');
            //   $('.loader').remove();
            //   $('[name="file"]').val('');
            //   $('[name="title"]').val('');
            //   $('[name="description"]').val('');
          },
          error: function(error){
              console.log(error);
          }
      }).done(function(data){
          console.log(data);
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

//TODO voir file API !

// $(".upload-click").click(function(e){
//     $('#input-file-upload').trigger('click'); //trigger click
// });
//
// if(window.File && window.FileReader && window.FileList && window.Blob){
//     oFReader = new FileReader(), rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
//     if(!rFilter.test(oFile.type))
//         {
//             alert('Unsupported file type!');
//             // return false;
//         }
// //Do other stuff
// }else{
//     alert("Can't upload! Your browser does not support File API!");
// } -->
 </script>
