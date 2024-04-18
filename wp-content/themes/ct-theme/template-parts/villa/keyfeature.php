<?php if ($args['features']) { ?>
    <div class="villa-keyfeature">
        <h2 class="villa-keyfeature__title"><?php _e('Key feature', CTTHEME_LANG_TEXT) ?></h2>
        <div class="villa-keyfeature__list">
            <?php foreach ($args['features'] as $feature) { ?>
                <div class="villa-keyfeature__item">
                    <div class="villa-keyfeature__item-icon">
                        <?php echo wp_get_attachment_image(get_field('icon', get_term($feature)), 'full'); ?>
                    </div>
                    <span class="villa-keyfeature__item-label"><?php echo get_term($feature)->name ?></span>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>