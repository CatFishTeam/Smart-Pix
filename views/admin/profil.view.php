<h1>On affiche : </h1>
<ul>
    <li>Affichage des stats (nombre de pages, nombre de photos etc)
    <li>
    <li>
    <li>
    <li>
    <li>
    <li>
</ul>
<form action="/admin/editProfil">
    Titre de la page : <input type="text" name="title" /><br>
    Est la page de présentation : <input type="checkbox" name="is_presentation" /><br>
    Description : <textarea name="desc"></textarea>
</form>
<script>
     CKEDITOR.replace( 'desc' );
 </script>
