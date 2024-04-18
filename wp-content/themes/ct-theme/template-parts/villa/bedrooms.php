<?php if ($args['bedrooms']) { ?>
    <div class="villa-bedrooms">
        <div class="villa-bedrooms__header">
            <h2 class="villa-bedrooms__header-title"><?php _e('Bedrooms', CTTHEME_LANG_TEXT) ?></h2>
            <button class="villa-bedrooms__header-plan ct-btn-plan ct-icon" data-icon-pos="left"><?php _e('Floor Plan', CTTHEME_LANG_TEXT) ?></button>
        </div>

        <div class="villa-bedrooms__slider">
            <div class="villa-bedrooms__swiper swiper">
                <div class="villa-bedrooms__wrapper swiper-wrapper">

                    <?php foreach ($args['bedrooms'] as $bedroom) { ?>

                        <div class="villa-bedrooms__slide swiper-slide">

                            <?php if ($bedroom['sizes']) { ?>
                                <div class="villa-bedrooms__slide-icons">

                                    <?php foreach ($bedroom['sizes'] as $size) { ?>
                                        <div class="villa-bedrooms__slide-icon">
                                            <?php echo wp_get_attachment_image(get_field('icon', get_term($size['type'])), 'full') ?>
                                            <?php if (intval($size['count']) > 1) { ?>
                                                <span class="villa-bedrooms__slide-icon__count"><?php echo $size['count'] ?></span>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                </div>
                            <?php } ?>

                            <h3 class="villa-bedrooms__slide-title"><?php echo $bedroom['name'] ?></h3>
                            <p class="villa-bedrooms__slide-desc">
                                <?php
                                // Bedroom Type
                                if ($bedroom['sizes']) {
                                    foreach ($bedroom['sizes'] as $size) {
                                        if (isset(get_term($size['type'])->name)) {
                                            echo get_term($size['type'])->name . ' (' . $size['count'] . '), ';
                                        }
                                    }
                                }

                                // View Type
                                if (isset($bedroom['view']) && isset(get_term($bedroom['view'])->name)) {
                                    echo get_term($bedroom['view'])->name;
                                }
                                ?>
                            </p>
                        </div>

                    <?php } ?>
                </div>
            </div>
            <button class="villa-bedrooms__slider-prev swiper-button-prev ct-btn-prev"><i class="ct-icon ct-icon--outline-next"></i></button>
            <button class="villa-bedrooms__slider-next swiper-button-next ct-btn-next"><i class="ct-icon ct-icon--outline-next"></i></button>
        </div>
        <?php if ($args['capacity']) { ?>
            <div class="villa-bedrooms__capacity">
                <p><?php echo $args['capacity'] ?></p>
            </div>
        <?php  } ?>
    </div>
<?php } ?>