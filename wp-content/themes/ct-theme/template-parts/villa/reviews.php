<div class="villa-reviews" id="reviews">

    <div class="villa-reviews__header">
        <h2 class="villa-reviews__title">
            <?php echo $args['reviews'] ? __('Reviews', CTTHEME_LANG_TEXT) : __('No reviews (yet)', CTTHEME_LANG_TEXT) ?>
        </h2>
        <?php if ($args['reviews']) { ?>
            <span class="villa-reviews__rate ct-icon ct-icon--fill-star" data-icon-pos="left"><?php echo $args['rating'] ?></span>
        <?php } ?>
    </div>

    <?php if ($args['reviews']) { ?>
        <div class="villa-reviews__list">
            <?php foreach ($args['reviews'] as $review) { ?>
                <div class="villa-reviews__item">
                    <div class="villa-reviews__item-header">
                        <div class="villa-reviews__item-rate">
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <i class="villa-reviews__item-rate--<?php echo $i < $review['rating'] ? 'yellow' : 'default' ?> ct-icon ct-icon--fill-star"></i>
                            <?php } ?>
                        </div>
                        <p class="villa-reviews__item-title"><strong><?php echo $review['author_name'] ?></strong> - <?php echo date('M j,Y', $review['time']) ?></p>
                    </div>
                    <div class="villa-reviews__item-content">
                        <p><?php echo $review['text'] ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php if (count($args['reviews']) > 2) { ?>
            <button class="villa-reviews__btn ct-btn-primary ct-icon" data-btn-size="l" data-icon-pos="right" data-default-text="<?php _e('Read more reviews', CTTHEME_LANG_TEXT) ?>" data-alt-text="<?php _e('Read less reviews', CTTHEME_LANG_TEXT) ?>"><?php _e('Read more reviews', CTTHEME_LANG_TEXT) ?></button>
        <?php } ?>

    <?php } else { ?>
        <div class="villa-reviews__nothing">
            <p><?php _e('Lorem ipsum dolor sit amet consectetur. Ac nec metus ut vestibulum pellentesque. Dolor blandit in eu gravida nibh. Vulputate vitae arcu ornare imperdiet risus. ', CTTHEME_LANG_TEXT) ?></p>
        </div>
    <?php } ?>
</div>