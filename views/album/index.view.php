<div class="row">
    <?php if (isset($album) && !empty($album)): ?>
        <div class="col-12">
            <div class="albumTitle" style="background-image: url('/public/cdn/images/<?php echo $album->getThumbnailUrl(); ?>');">
                <h2><?php echo $album->getTitle(); ?></h2>
            </div>
            <h3 class="italic">Par <a href="<?php echo PATH_RELATIVE; ?>user/wall/<?php echo $author->getId(); ?>"><?php echo $author->getUsername(); ?></a></h3>
            <p><?php echo $album->getDescription(); ?></p>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $author->getId()): ?>
            <p>
                <button id="albumBtn" class="btn">Ajouter des images à l'album</button>
                <a href="<?php echo PATH_RELATIVE; ?>album/edit/<?php echo $album->getId(); ?>" class="btn">Editer l'album</a>
            </p>
            <div id="albumModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close"><i class="fa fa-times" aria-hidden="true"></i></span>
                        <h2>Choisissez une ou plusieurs images</h2>
                    </div>
                    <div class="modal-body">
                        <p class="album-search form-group">
                            <input type="text" placeholder="Recherchez vos images par titre, description">
                        </p>
                        <p class="album-pictures">
                            <?php foreach ($pictures as $picture): ?>
                                <img src="<?php echo PATH_RELATIVE."public/cdn/images/". $picture['url']; ?>" data-title="<?php echo $picture['title']; ?>" data-description="<?php echo $picture['description']; ?>" alt="<?php echo $picture['title']; ?>">
                            <?php endforeach; ?>
                        </p>
                        <p>
                            <button type="button" class="btn add-album-pictures" disabled>Aucune image sélectionnée</button>
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
    $(document).ready(function() {
        var modal = document.getElementById('albumModal');
        var input = modal.querySelector(".album-search input");
        var btn = document.getElementById("albumBtn");
        var span = document.getElementsByClassName("close")[0];
        var nbSelected = 0;

        btn.onclick = function() {
            modal.style.display = "block";
            input.focus();
        };

        span.onclick = function() {
            modal.style.display = "none";
        };

        window.onclick = function(e) {
            if (e.target == modal) {
                modal.style.display = "none";
            }
        };

        $('.album-search input').on('input', function(e) {
            var img = $('.album-pictures img');
            $.each(img, function() {
                if (
                    ($(this).attr('data-title').toLowerCase().indexOf(e.currentTarget.value.toLowerCase()) != -1 ||
                     $(this).attr('data-description').toLowerCase().indexOf(e.currentTarget.value.toLowerCase()) != -1) &&
                    $.trim(e.currentTarget.value) != ""
                ) {
                    $(this).css("display", "inline-block");
                } else {
                    $(this).css("display", "none");
                }
                if ($.trim(e.currentTarget.value) == "")
                    $(this).css("display", "inline-block");
            });
        });

        $('body').on('click', '.album-pictures img', function(e) {
            var img = $(this);
            img.toggleClass("selected");
            if (img.hasClass("selected")) {
                nbSelected++;
                img.css("border", "5px solid #2ecc71");
                img.css("background-color", "#2ecc71");
            } else {
                nbSelected--;
                img.css("border", "0");
                img.css("background-color", "transparent");
            }

            if (nbSelected < 1) {
                $('.add-album-pictures').text("Aucune image sélectionnée");
                $('.add-album-pictures').prop('disabled', true);
            }
            else if (nbSelected == 1) {
                $('.add-album-pictures').text("Ajouter l'image à l'album");
                $('.add-album-pictures').prop('disabled', false);
            }
            else {
                $('.add-album-pictures').text("Ajouter les " + nbSelected + " images à l'album");
                $('.add-album-pictures').prop('disabled', false);
            }

        });
    });


</script>