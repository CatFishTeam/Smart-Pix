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
        button.unpublish{
            background: orange;
            border-radius: 6px;
            color: #fff;
            font-size: 20px;
        }
    </style>

    TODO :
    <br />• Pagination
    <br />• Mettre en avant les commentaires qui n'ont pas encore étés modérés

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
                <?php echo $comment['content'] ?>
            </td>
            <td>
                <a href="/picture/<?php echo $comment['picture_id'] ?>"><?php echo $comment['picture_id'] ?></a>
            </td>
            <td>
                <?php echo $comment['username'] ?>
            </td>
            <td>
                <button type="button" class="delete"><i class="fa fa-times" aria-hidden="true"></i></button>
                <button type="button" class="publish" style="display: <?php echo $comment['is_published'] == 0  ? 'inline-block' : 'none' ?>"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <button type="button" class="unpublish" style="display: <?php echo $comment['is_published'] == 0  ? 'none' : 'inline-block' ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></i></button>
            </td>
        </tr>
    <?php endforeach ?>

    <script>
        //TODO : Json Response
        $('.delete').click(function(){
            $el = $(this).parents('tr');
            $.ajax({
              url: "/<?php echo($_SESSION['community_slug']) ?>/admin/deleteComment",
              type: "POST",
              dataType: "json",
              data: {id: $el.data('id')},
              success: function(data){
                  $('body').append(data);
                  flash();
                  $el.fadeOut(function(){
                      $el.remove();
                  });
              }
            });
        });

        $('.publish').click(function(){
            $el = $(this).parents('tr');
            $.ajax({
                url: "/<?php echo($_SESSION['community_slug']) ?>/admin/publishComment",
                type: "POST",
                dataType: "json",
                data: {id: $el.data('id')},
                success: function(data){
                    $('body').append(data);
                    flash();
                    $el.find('.publish').fadeOut(function(){
                        $el.find('.unpublish').fadeIn();
                    });
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

        $('.unpublish').click(function(){
            $el = $(this).parents('tr');
            $.ajax({
                url: "/<?php echo($_SESSION['community_slug']) ?>/admin/unpublishComment",
                type: "POST",
                dataType: "json",
                data: {id: $el.data('id')},
                success: function(data){
                    $('body').append(data);
                    flash();
                    $el.find('.unpublish').fadeOut(function(){
                        $el.find('.publish').fadeIn();
                    });
                }
            });
        });
    </script>
    </table>
