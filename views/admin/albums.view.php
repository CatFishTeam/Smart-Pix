<!--
TODO
• Faire vérification avant l'envoi en js ou en php ?
• Ajouter une page et éditer son contenu (modifier )
• Apercu si pages spécifique séléctionné (A faire sur une autre page de type : /pages/nomDeLaPage)
• Gérer erreur plusieurs page de présentation ? (Afficher la dernière en date uniquement mais un message de warning quand même)
-->
<div class="row" style="padding: 0 15px;">
    <div style="width: 100%;margin: 0 -15px;padding: 15px;">
        <input type="text" />
        <button type="button" name="button">+</button>
        <button type="button" name="button">-</button>
    </div>
    <div style="width: 20%;">
        <?php foreach ($albums as $album): ?>
            <li><?php  echo $album['title']  ?>
        <?php endforeach ?>
    </div>
    <div style="width: 80%; background: red;">        
        <form action="/album/addalbum" type="POST">
            Titre de la page : <input type="text" name="title" /><br>
            Est la page de présentation : <input type="checkbox" name="is_presentation" /><br>
            Est publié : <input type="checkbox" name="is_published" /><br>
            Description : <textarea name="description"></textarea>
            <button type="button" name="addAlbum">Envoyer</button>
        </form>
        <script>
        $('[name=addAlbum]').click(function(){
            $form = $(this).parent();
            $.ajax({
                url : '/album/addAlbum',
                method: 'POST',
                data  : $form.serialize(),
            }).done(function(data){
                console.log(data);
            })
        });
        </script>
    </div>

</div>
