<div class="container">
    <div class="row">
        <div class="col-12">
            <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/communities" class="btn btn-login">Mes communautés</a>
            <?php else: ?>
                <p><a href="/login">Connectez-vous</a> pour voir ou créer vos communautés.</p>
            <?php
            endif;
            ?>
            <h2 class="align-left">Dernières communautés</h2>
            <table class="table-communities">
                <?php
                if(isset($communities)):
                    foreach ($communities as $community):
                        $date = strtotime($community['created_at']);
                        $author = new User();
                        $author = $author->populate(['id' => $community['user_id']]);
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
                        <p>Créée le <?php echo date("d/m/Y", $date); ?> par <a href="user/<?php echo $author->getId(); ?>"><?php echo $author->getUsername(); ?></a></p>
                    </td>
                </tr>
                <?php
                    endforeach;
                endif;
                ?>
            </table>
        </div>
    </div>
    <hr />
    <?php include 'components/infiniteScrollIndex.php'; ?>
</div>
