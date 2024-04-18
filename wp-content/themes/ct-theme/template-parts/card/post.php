<a class="card-post" href="<?php echo get_permalink() ?>">
    <div class="card-post__image">
        <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full') ?>
    </div>
    <div class="card-post__content">
        <p class="card-post__date"><?php echo get_the_time('F j, Y') ?></p>
        <h2 class="card-post__title"><?php echo get_the_title() ?></h2>
        <p class="card-post__excerpt"><?php echo ct_theme_get_the_excerpt(get_post(), 102, '...') ?></p>
        <p class="card-post__link ct-icon ct-icon--outline-viewall" data-icon-pos="right"><?php _e('Read more', CTTHEME_LANG_TEXT) ?></p>
    </div>
</a>