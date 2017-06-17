<h1>On affiche : </h1>
<br>Rang 4 : Super Utilisateurs (créateur du thread)
<br>Rang 3 : Administrateur : peut ban des utilisateurs, changer leurs rang...
<br>Rang 2 : Modérateur : Peut modérer les commentaires des images
<br>Rang 1 : Simple utilisateur : peut poster
<br>Rang 0 : Peut visualiser ? (Pas inscrit du coup)


        <table>
            <th>Username</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
            <th>Last Update</th>
        <?php foreach ($users as $user): ?>
            <tr data-id="<?php echo $user['id'] ?>">
                <td><?php echo $user['username'] ?></td>
                <td><a href="mailto:<?php echo $user['email'] ?>"><?php echo $user['email'] ?></a></td>
                <td>
                    <select name="permission">
                        <option data-id="4" <?php echo ($user['permission'] == 4) ? "selected" : ""; ?>>Super Administrateur</option>
                        <option data-id="3" <?php echo ($user['permission'] == 3) ? "selected" : ""; ?>>Administrateur</option>
                        <option data-id="2" <?php echo ($user['permission'] == 2) ? "selected" : ""; ?>>Modérateur</option>
                        <option data-id="1" <?php echo ($user['permission'] == 1) ? "selected" : ""; ?>>Membre</option>
                    </select>
                </td>
                <td><button class="ban">Bannir</button></td>
                <td><?php echo $user['updated_at'] ?></td>
            </tr>
        <?php endforeach ?>
        </table>

        <script>
            $('[name="permission"]').change(function(){
                $this = $(this);
                $.ajax({
                    url: '/admin/userPermission',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        permission: $this.find('option:selected').data('id'),
                        user_id: $this.parents('tr').data('id')
                    },
                    success: function(data){
                            $this.parents('tr').find('td:last').text(data.date);
                    }
                });
            });

        //     $('.ban').click(function(){
        //         $el = $(this).parents('tr');
        //         $.ajax({
        //                 url: '/admin/userBan',
        //                 type: 'POST',
        //                 dataType: 'json',
        //                 data: {
        //                     user_id: $el.data('id'),
        //
        //                 }
        //         });
        //     });
        </script>

</ul>
