<?php if ($args['included'] || $args['extra']) { ?>
    <div class="villa-rental">
        <div class="villa-rental__included">
            <h2 class="villa-rental__title"><?php _e('What is included', CTTHEME_LANG_TEXT) ?></h2>
            <div class="villa-rental__content">
                <?php echo $args['included'] ?>
            </div>
        </div>

        <div class="villa-rental__extra">
            <h2 class="villa-rental__title"><?php _e('At extra cost', CTTHEME_LANG_TEXT) ?></h2>
            <div class="villa-rental__content">
                <?php echo $args['extra'] ?>
            </div>
        </div>
    </div>
<?php } ?>