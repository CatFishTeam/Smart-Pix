<h1>On affiche : </h1>
    <style>
        /* TODO create global class* */
        button.delete{
            background: red;
            border-radius: 6px;
            color: #fff;
            font-size: 20px;
        }
        button.publish{
            background: green;
            border-radius: 6px;
            color: #fff;
            font-size: 20px;
        }
    </style>

    TODO : • Pagination
    <br />• Mettre en avant les fichiers qui n'ont pas étés validés

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
        <tr data-id="<?php echo $comment['id'] ?>">
            <td>
                <?php echo $comment['id'] ?>
                <?php echo $comment['content'] ?>
            </td>
            <td>
                <?php echo $comment['picture_id'] ?>
            </td>
            <td>
                <?php echo $comment['username'] ?>
            </td>
            <td>
                <button type="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></button>
                <?php echo ($comment['is_published'] == 0 ? '<button type="button" class="publish"><i class="fa fa-check" aria-hidden="true"></i></button>' : '<button type="button" class=""><i class="fa fa-check" aria-hidden="true"></i></button>') ?>
            </td>
        </tr>
    <?php endforeach ?>

    <script>
        //TODO : Json Response
        $('.delete').click(function(){
            $el = $(this).parents('tr');
            $.ajax({
              url: "/admin/deleteComment",
              type: "POST",
              data: {id: $el.data('id')},
              success: function(data){
                  $el.fadeOut(function(){
                      $el.remove();
                  });
              }
            });
        });

        $('.publish').click(function(){
            $el = $(this).parents('tr');
            $.ajax({
                url: "/admin/publishComment",
                type: "POST",
                data: {id: $el.data('id')},
                success: function(data){
                    console.log(data);
                }
            });
        });

        $('.unpublish').click(function(){
            $el = $(this).parents('tr');
            $.ajax({
                url: "/admin/unpublishComment",
                type: "POST",
                data: {id: $el.data('id')},
                success: function(data){
                    console.log(data);
                }
            });
        });
    </script>
    </table>
