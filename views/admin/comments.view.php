<h1>On affiche : </h1>

    <table>
        <tr>
            <th>
                Commentaire
            </th>
            <th>
                Photo
            </th>
            <th>
                Utilisateur
            </th>
            <th>
                Actions
            </th>
        </tr>
    <?php foreach($allComments as $comment): ?>
        <tr>
            <td>
                <?php echo $comment['content'] ?>
            </td>
            <td>
                <?php echo $comment['picture_id'] ?>
            </td>
            <td>
                <?php echo $comment['username'] ?>
            </td>
            <td>
                ACTIONNNNS
            </td>
        </tr>
    <?php endforeach ?>
    </table>



<ul>
    <li>CRUD GESTION DES COMMENTAIRES PROPRE AU USER
</ul>
