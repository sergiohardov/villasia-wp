<?php
$villas = null;
$params = [];

switch ($args['type_related']) {
    case 'auto':
        $params = [
            'post_type' => CTCORE_POST_TYPE_VILLA,
            'meta_key' => CTCORE_FIELD_VILLA_AREA_ID,
            'meta_value' => $args['area_id'],
            'posts_per_page' => 3,
            'post__not_in' => [$args['current_id']]
        ];
        break;

    case 'manual':
        $arr = array_diff($args['manual_villas'], [$args['current_id']]);
        if (!$arr) break;

        $params = [
            'post_type' => CTCORE_POST_TYPE_VILLA,
            'post__in' => $arr,
        ];
        break;

    default:
        break;
}

$villas = new WP_Query($params);
?>

<?php if ($villas->have_posts()) { ?>
    <section class="villa-related">
        <div class="ct-container">
            <h2 class="villa-related__title"><?php _e('Related Villas', CTTHEME_LANG_TEXT); ?></h2>
            <div class="villa-related__slider">
                <div class="villa-related__swiper swiper">
                    <div class="villa-related__swiper-wrapper swiper-wrapper">
                        <?php while ($villas->have_posts()) { ?>
                            <?php $villas->the_post(); ?>
                            <div class="villa-related__swiper-slide swiper-slide">
                                <?php get_template_part('template-parts/card/villa'); ?>
                            </div>
                        <?php } ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                    <div class="villa-related__pagination swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>