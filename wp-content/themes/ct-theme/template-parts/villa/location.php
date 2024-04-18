<?php if (!empty($args['location']) || !empty($args['desc'])) { ?>
    <div class="villa-location" id="location">
        <h2 class="villa-location__title"><?php _e('Location', CTTHEME_LANG_TEXT) ?></h2>
        <?php if ($args['location']) { ?>
            <div class="villa-location__map">
                <div id="map">
                    <div class="marker" data-lat="<?php echo $args['location']['lat']; ?>" data-lng="<?php echo $args['location']['lng']; ?>"></div>
                </div>
            </div>
        <?php } ?>
        <div class="villa-location__desc">
            <?php echo $args['desc'] ?>
        </div>
    </div>
<?php } ?>