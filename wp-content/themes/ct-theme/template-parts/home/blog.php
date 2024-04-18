<section class="home-blog">
    <div class="ct-container">
        <div class="home-blog__inner">
            <h2 class="home-blog__title"><?php echo $args['title'] ?></h2>

            <?php
            $query_args = [
                'post_type' => 'post',
                'posts_per_page' => 4
            ];

            $the_query = new WP_Query($query_args);
            ?>

            <?php if ($the_query->have_posts()) { ?>
                <div class="home-blog__slider swiper">
                    <div class="home-blog__list swiper-wrapper">
                        <?php while ($the_query->have_posts()) { ?>
                            <?php $the_query->the_post(); ?>
                            <div class="home-blog__item swiper-slide">
                                <a class="home-blog__item-image" href="<?php the_permalink() ?>">
                                    <?php echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'full') ?>
                                </a>

                                <div class="home-blog__item-content">
                                    <p class="home-blog__item-date"><?php the_time('F d, Y') ?></p>
                                    <a class="home-blog__item-link" href="<?php the_permalink() ?>">
                                        <h3 class="home-blog__item-title"><?php the_title() ?></h3>
                                    </a>
                                    <div class="home-blog__item-desc"><?php echo ct_theme_get_the_excerpt(get_post(), 260) ?></div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                    <div class="home-blog__pagination swiper-pagination"></div>
                </div>

                <a class="home-blog__link ct-btn-primary ct-icon ct-icon--outline-viewall" data-btn-size="l" data-icon-pos="right" href="<?php echo get_permalink(get_option('page_for_posts')) ?>"><?php _e('View all blog posts', CTTHEME_LANG_TEXT) ?></a>
            <?php } else { ?>
                <p><?php _e('No posts in blog.', CTTHEME_LANG_TEXT) ?></p>
            <?php } ?>
        </div>
    </div>
</section>