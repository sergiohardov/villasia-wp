<?php if ($args['images']) { ?>
    <section class="villa-gallery">
        <div class="ct-container">
            <div class="villa-gallery__inner">

                <div class="villa-gallery__list">
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                        <?php if (isset($args['images'][$i])) { ?>
                            <a class="villa-gallery__item" data-fancybox="villa-gallery" href="<?php echo wp_get_attachment_image_url($args['images'][$i], 'full'); ?>">
                                <?php echo wp_get_attachment_image($args['images'][$i], 'full'); ?>
                            </a>
                        <?php } ?>
                    <?php } ?>

                    <div style="display:none">
                        <?php for ($i = 5; $i < count($args['images']); $i++) { ?>
                            <a data-fancybox="villa-gallery" href="<?php echo wp_get_attachment_image_url($args['images'][$i], 'full'); ?>">
                                <img data-lazy-src="<?php echo wp_get_attachment_image_url($args['images'][$i], 'full'); ?>" />
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="villa-gallery__counter">
                    <i class="ct-icon ct-icon--fill-image"></i>
                    <span><?php echo count($args['images']) ?></span>
                </div>

            </div>
        </div>
    </section>
<?php } ?>