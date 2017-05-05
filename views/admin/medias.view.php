<h1>On affiche : </h1>
<ul>
    <li>Editer un media
    <li>
    <li>Check sur le title if empty prevent send
    <li>Informer utilisateur sur la taille restante disponible pour celui-ci (mettre a jour si l'on retire etc)
    <li>-> Rendre payant une fois un certain espace de stockage atteint ou proposer un autre système (compression image etc..)
</ul>

<form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitForm();">
    <label>Select a file:</label><br>
    <input type="file" name="file">
    Title : <input type="text" name="title">
    Description : <textarea name="description"></textarea>
    <input type="submit" value="Upload" />
</form>
<div id='output'>
    <?php foreach($pictures as $picture): ?>
        <div class="imageContainer relative">
            <a href="#"></a>
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
$(document).on('click','.delete',function(){
    var _ = $(this);
    var url = _.data('url');
    $.ajax({
      url: "/admin/mediaDelete",
      type: "POST",
      dataType: 'json',
      data: { url: url }
    }).done(function( data ) {
        console.log(data.msg);
        _.parent().fadeOut(300, function() {
            _.parent().remove();
        })
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

     function submitForm() {
         var fd = new FormData(document.getElementById("fileinfo"));
         $.ajax({
           url: "/admin/mediaUpload",
           type: "POST",
           data: fd,
           processData: false,  // tell jQuery not to process the data
           contentType: false   // tell jQuery not to set contentType
         }).done(function( data ) {
             data = JSON.parse(data);
             console.log(data.msg);
             $('#output').prepend('<div class="imageContainer relative"><a href="#"></a><button class="delete" data-url="'+data.img+'"><i class="fa fa-times" aria-hidden="true"></i></button><img src="/public/cdn/images/thumbnails/'+data.img+'" /></div>');
         });
         return false;
     }
 </script>
