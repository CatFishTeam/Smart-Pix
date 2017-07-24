<div class="row">
    <div class="col-12">
        <?php if (isset($tag) && $tag): ?>
        <h2>Images avec le tag « <?php echo $tag->getTitle(); ?> »</h2>
        <?php endif; ?>
    </div>
</div>