<div class="row">
    <a href="/community/create" class="btn btn-login">Créer une communauté</a>
    <div class="col-12">
        <h2 class="align-left">Mes communautés</h2>
        <table class="table-communities">
            <?php
            if(isset($communities)):
                foreach ($communities as $community):
                    $date = strtotime($community['created_at']);
                    ?>
                    <tr>
                        <td><p>»</p></td>
                        <td>
                            <p><a href="<?php echo "/".$community['slug']; ?>"><?php echo $community['name']; ?></a></p>
                        </td>
                        <td>
                            <p><?php echo $community['description']; ?></p>
                        </td>
                        <td>
                            <p>Créée le <?php echo date("d/m/Y", $date); ?></p>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
        </table>
    </div>
</div>
