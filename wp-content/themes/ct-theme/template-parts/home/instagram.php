    <section class="home-instagram">
        <div class="ct-container">
            <h2 class="home-instagram__title"><?php echo $args['title'] ?></h2>

            <?php if ($args['media']) { ?>
                <div class="home-instagram__slider">
                    <div class="swiper">
                        <div class="home-instagram__wrapper swiper-wrapper">
                            <?php foreach ($args['media'] as $item) { ?>
                                <?php if ($item['media_type'] === 'IMAGE') { ?>
                                    <a class="home-instagram__slide swiper-slide" href="<?php echo $item['permalink'] ?>">
                                        <img src="<?php echo $item['media_url'] ?>" alt="<?php echo mb_strimwidth($item['caption'], 0, 50, "...") ?>">
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="home-instagram__pagination swiper-pagination"></div>
                    <div class="home-instagram__btn-prev ct-btn-prev swiper-button-prev"><i class="ct-icon ct-icon--outline-next"></i></div>
                    <div class="home-instagram__btn-next ct-btn-next swiper-button-next"><i class="ct-icon ct-icon--outline-next"></i></div>
                </div>
            <?php } else { ?>
                <p><?php _e('Feed not have post or API error.', CTTHEME_LANG_TEXT) ?></p>
            <?php } ?>

        </div>
    </section>