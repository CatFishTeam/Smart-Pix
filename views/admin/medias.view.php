<h1>On affiche : </h1>
<ul>
    <li>Ajouter un media et éditer
    <li>Listing des medias + afficher miniature
    <li>Media on host : Miniature + Taille original
    <li>UTILISER MODEL POUR L'IMPORE
    <li>Limiter taille upload ou automatiquement redimenssioner ?
    <li>Rendre payant une fois un certain espace de stockage atteint ou proposer un autre système (compression image etc..)
    <li>IE9 Upload File Ajax ??
</ul>

<form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitForm();">
    <label>Select a file:</label><br>
    <input type="file" name="file">
    Title : <input type="text" name="title">
    Description : <textarea name="description"></textarea>
    <input type="submit" value="Upload" />
</form>
<div id="output"></div>

<script type="text/javascript">
     function submitForm() {
         var fd = new FormData(document.getElementById("fileinfo"));
         $.ajax({
           url: "/admin/mediaUpload",
           type: "POST",
           data: fd,
           processData: false,  // tell jQuery not to process the data
           contentType: false   // tell jQuery not to set contentType
         }).done(function( data ) {
             $('#output').append(data);
         });
         return false;
     }
 </script>
