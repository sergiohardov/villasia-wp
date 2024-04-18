<?php if ($args['villas']->have_posts()) { ?>
    <section class="home-promotions">
        <div class="ct-container">
            <h2 class="home-promotions__title"><?php echo $args['title']; ?></h2>

            <div class="home-promotions__cards swiper">
                <div class="home-promotions__wrapper swiper-wrapper">

                    <?php $idx = 0; ?>
                    <?php while ($args['villas']->have_posts()) { ?>
                        <?php $idx++; $args['villas']->the_post(); ?>
                        
                        <div class="home-promotions__item <?php if ($idx > 6) echo 'home-promotions__item--hidden' ?> swiper-slide ">
                            <?php get_template_part('template-parts/card/villa'); ?>
                        </div>

                    <?php } ?>
                    <?php wp_reset_postdata() ?>
                </div>
                <div class="home-promotions__pagination swiper-pagination"></div>
            </div>

            <?php if ($args['villas']->post_count > 6) { ?>
                <button class="home-promotions__more ct-btn-primary ct-icon" data-btn-size="l" data-icon-pos="right" data-text-default="<?php _e('Show more', CTTHEME_LANG_TEXT) ?>" data-text-alt="<?php _e('Show less', CTTHEME_LANG_TEXT) ?>"><?php _e('Show more', CTTHEME_LANG_TEXT) ?></button>
            <?php } ?>
        </div>
    </section>
<?php } ?>