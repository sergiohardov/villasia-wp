<div class="villa-overview" id="overview">
    <div class="villa-overview__header">
        <h1 class="villa-overview__header-title">
            <?php echo $args['best_choice'] ? $args['title'] . '<i class="ct-icon ct-icon--fill-award"></i>' : $args['title']; ?>
        </h1>

        <div class="villa-overview__header-controls">
            <div class="villa-overview__header-controls__rating">
                <?php if ($args['rate']) { ?>
                    <div class="villa-overview__rating">
                        <span class="villa-overview__rating-rate ct-icon ct-icon--fill-star" data-icon-pos="left"><?php echo $args['rate']; ?></span>
                        <a class="villa-overview__rating-link" href="#"><?php _e('See the latest reviews', CTTHEME_LANG_TEXT) ?></a>
                    </div>
                <?php } ?>
            </div>

            <button class="villa-overview__fav"><i class="ct-icon"></i></button>
        </div>
    </div>

    <div class="villa-overview__details">
        <div class="villa-overview__details-info">
            <span class="ct-icon ct-icon--fill-map" data-icon-pos="left"><?php echo $args['location']; ?></span>
            <span class="ct-icon ct-icon--fill-person" data-icon-pos="left"><?php echo $args['guests'] . ' ' . __('Guests', CTTHEME_LANG_TEXT); ?></span>
            <span class="ct-icon ct-icon--fill-bed" data-icon-pos="left"><?php echo $args['bedrooms'] . ' ' . __('Bedrooms', CTTHEME_LANG_TEXT); ?></span>
            <span class="ct-icon ct-icon--fill-bathtub" data-icon-pos="left"><?php echo $args['bathrooms'] . ' ' . __('Bathrooms', CTTHEME_LANG_TEXT); ?></span>
        </div>

        <div class="villa-overview__details-rating">
            <?php if ($args['rate']) { ?>
                <div class="villa-overview__rating">
                    <span class="villa-overview__rating-rate ct-icon ct-icon--fill-star" data-icon-pos="left"><?php echo $args['rate']; ?></span>
                    <a class="villa-overview__rating-link" href="#"><?php _e('See the latest reviews', CTTHEME_LANG_TEXT) ?></a>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="villa-overview__content">
        <?php echo $args['desc'] ?>
    </div>
</div>