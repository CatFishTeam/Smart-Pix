<div class="row">
    <?php if (isset($album) && !empty($album)): ?>
        <div class="col-12">
            <h2><?php echo $album->getTitle(); ?></h2>
            <h3 class="italic">Par <?php echo $author->getUsername(); ?></h3>
            <p><?php echo $album->getDescription(); ?></p>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $author->getId()): ?>
            <p>
                <button id="albumBtn" class="btn">Ajouter une image</button>
                <a href="<?php echo PATH_RELATIVE; ?>album/edit/<?php echo $album->getId(); ?>" class="btn">Editer l'album</a>
            </p>
            <div id="albumModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close"><i class="fa fa-times" aria-hidden="true"></i></span>
                        <h2>Choisissez une image</h2>
                    </div>
                    <div class="modal-body">
                        <p>
                            <?php foreach ($pictures as $picture): ?>
                                <img src="<?php echo PATH_RELATIVE."public/cdn/images/". $picture['url']; ?>" class="add-album-picture" alt="<?php echo $picture['title']; ?>" width="150">
                            <?php endforeach; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    <?php elseif (isset($album) && empty($album)): ?>
        <div class="col-12">
            <p>Cet album n'existe pas.</p>
        </div>
    <?php else: ?>
        <div class="col-12">
            <p>Listing des albums</p>
        </div>
    <?php endif; ?>

</div>

<script>
    var modal = document.getElementById('albumModal');
    var btn = document.getElementById("albumBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    };

    span.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>