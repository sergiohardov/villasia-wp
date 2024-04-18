<section class="slider-locations">
    <div class="ct-container">
        <div class="slider-locations__inner">
            <h2 class="slider-locations__title"><?php echo $args['title'] ?></h2>

            <?php if (isset($args['content']) && $args['content']) { ?>
                <div class="slider-locations__content">
                    <?php echo $args['content'] ?>
                </div>
            <?php } ?>

            <?php if (isset($args['locations'])) { ?>
                <?php if ($args['locations']) { ?>
                    <div class="slider-locations__container">
                        <div class="slider-locations__swiper swiper">
                            <div class="slider-locations__wrapper swiper-wrapper">

                                <?php foreach ($args['locations'] as $location) { ?>
                                    <?php $slide_data = [
                                        'image' => get_field('image', get_term($location)),
                                        'title' => get_field('country', get_term($location)) ? get_term($location)->name . ', ' . get_term(get_field('country', get_term($location)))->name : get_term($location)->name,
                                        'link' => get_term_link(get_term($location)),
                                    ]; ?>
                                    <a class="slider-locations__slide swiper-slide" href="<?php echo $slide_data['link'] ?>">

                                        <div class="slider-locations__slide-bg">
                                            <?php echo wp_get_attachment_image($slide_data['image'], 'full') ?>
                                        </div>
                                        <div class="slider-locations__slide-content">
                                            <h3 class="slider-locations__slide-content__title"><?php echo $slide_data['title']; ?></h3>
                                            <span class="slider-locations__slide-content__span ct-icon ct-icon--outline-viewall" data-icon-pos="right"><?php _e('Find out more', CTTHEME_LANG_TEXT) ?></span>
                                        </div>
                                    </a>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="slider-locations__nav-prev ct-btn-prev swiper-button-prev"><i class="ct-icon ct-icon--outline-next"></i></div>
                        <div class="slider-locations__nav-next ct-btn-next swiper-button-next"><i class="ct-icon ct-icon--outline-next"></i></div>
                        <div class="slider-locations__nav-pagination swiper-pagination"></div>
                    </div>
                <?php } else { ?>
                    <h3><?php _e('No locations', CTTHEME_LANG_TEXT) ?></h3>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>