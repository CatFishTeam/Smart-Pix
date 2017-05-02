<h1>On affiche : </h1>
<ul>
    <li>Ajouter une page et éditer son contenu (modifier )
    <li>Listing des pages
    <li>Apercu si pages spécifique séléctionné (A faire sur une autre page de type : /pages/nomDeLaPage)
    <li>Gérer erreur plusieurs page de présentation ? (Afficher la dernière en date uniquement mais un message de warning quand même)
    <li>
    <li>
    <li>
</ul>
<h2>Créer page</h2>
<form action="/admin/addPage">
    Titre de la page : <input type="text" name="title" /><br>
    Est la page de présentation : <input type="checkbox" name="is_presentation" /><br>
    Description : <textarea name="desc"></textarea>
</form>
