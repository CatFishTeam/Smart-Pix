<div class="container">
    <div class="row">
        <div class="col-12">
            <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/communities" class="btn btn-login">Mes communautés</a>
            <?php else: ?>
                <p><a href="/login">Connectez-vous</a> pour voir ou créer vos communautés.</p>
            <?php
            endif;
//            include 'components/infiniteScroll.php';
            ?>

        </div>
    </div>
</div>
