<?php
global $wishlist_ids;

$check_in = isset($_GET['check_in']) ? $_GET['check_in'] : null;
$check_out = isset($_GET['check_out']) ? $_GET['check_out'] : null;
$bedroom = isset($_GET['bedroom']) ? $_GET['bedroom'] : 0;

$block_data = [
    'id'        => isset($args['id']) ? $args['id'] : get_the_ID(),
    'title'     => isset($args['title']) ? $args['title'] : get_the_title(),
    'map'       => isset($args['map']) ? $args['map'] : get_field('main_group_map'),
    'images'    => isset($args['images']) ? $args['images'] : get_field('photos_group'),
    'rating'    => isset($args['rating']) ? $args['rating'] : get_field(CTCORE_FIELD_VILLA_RATING),
    'link'      => isset($args['link']) ? $args['link'] : get_the_permalink(),
    'location'  => isset($args['location']) ? $args['location'] : ct_theme_get_format_location(get_field('main_group_city')),
    'guests'    => isset($args['guests']) ? $args['guests'] : get_field('main_group_guests'),
    'bedrooms'  => isset($args['bedrooms']) ? $args['bedrooms'] : get_field('main_group_bedrooms')
];

$block_data['in_wishlist'] = in_array($block_data['id'],  $wishlist_ids) ? '1' : '0';

$block_data['price'] = ct_core_get_villa_price($block_data['id'], $check_in, $check_out, $bedroom);
$block_data['best_choice'] = ct_core_villa_is_best_choice($block_data['id']);
?>

<div class="card-villa" data-villa-id="<?php echo $block_data['id'] ?>" data-in-wishlist="<?php echo $block_data['in_wishlist'] ?>" data-map-lat="<?php echo $block_data['map'] ? $block_data['map']['lat'] : '' ?>" data-map-lng="<?php echo $block_data['map'] ? $block_data['map']['lng'] : '' ?>">
    <?php if ($block_data['price']['discount']) { ?>
        <span class="card-villa__tag"><?php _e('Special offer', CTTHEME_LANG_TEXT); ?></span>
    <?php } ?>

    <div class="card-villa__swiper swiper">
        <div class="card-villa__swiper-wrapper swiper-wrapper">
            <?php if ($block_data['images']) { ?>
                <?php foreach ($block_data['images'] as $idx => $image) { ?>
                    <?php if ($idx > 4) break; ?>
                    <div class="card-villa__swiper-slide swiper-slide">
                        <?php echo wp_get_attachment_image($image, 'full') ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <button class="card-villa__swiper-prev swiper-button-prev ct-btn-prev"><i class="ct-icon ct-icon--outline-next"></i></button>
        <button class="card-villa__swiper-next swiper-button-next ct-btn-next"><i class="ct-icon ct-icon--outline-next"></i></button>
        <div class="card-villa__swiper-pagination swiper-pagination"></div>
    </div>

    <div class="card-villa__content">
        <div class="card-villa__header">
            <div class="card-villa__header-top">
                <a class="card-villa__header-top__title" href="<?php echo $block_data['link'] ?>"><?php echo $block_data['title'] ?></a>
                <?php if ($block_data['rating']) { ?>
                    <span class="card-villa__header-top__rate ct-icon ct-icon--fill-star" data-icon-pos="left"><?php echo $block_data['rating'] ?></span>
                <?php } ?>
            </div>
            <div class="card-villa__header-bottom">
                <div class="card-villa__header-bottom__location ct-icon ct-icon--fill-map" data-icon-pos="left">
                    <a href="#"><?php echo $block_data['location'] ?></a>
                </div>
                <span class="card-villa__header-bottom__guests ct-icon ct-icon--fill-person" data-icon-pos="left"><?php echo $block_data['guests'] ?></span>
                <span class="card-villa__header-bottom__bedrooms ct-icon ct-icon--fill-bed" data-icon-pos="left"><?php echo $block_data['bedrooms'] ?></span>
                <?php if ($block_data['best_choice']) { ?>
                    <span class="card-villa__header-bottom__best ct-icon ct-icon--fill-award" data-icon-pos="left"><?php _e('Best Choice', CTTHEME_LANG_TEXT) ?></span>
                <?php } ?>
            </div>
        </div>
        <div class="card-villa__footer">
            <div class="card-villa__footer-top">
                <p class="card-villa__footer-top__title">
                    <span class="card-villa__footer-top__title-price"><?php echo $block_data['price']['price']; ?></span>
                    <span class="card-villa__footer-top__title-nights"><?php echo $block_data['price']['nights']; ?></span>
                </p>
                <?php if ($block_data['price']['old_price']) { ?>
                    <p class="card-villa__footer-top__subtitle"><strike><?php echo $block_data['price']['old_price']; ?></strike></p>
                <?php } ?>

                <?php if ($block_data['price']['sub']) { ?>
                    <p class="card-villa__footer-top__subtitle"><?php echo $block_data['price']['sub']; ?></p>
                <?php } ?>

                <?php if ($block_data['price']['discount']) { ?>
                    <p class="card-villa__footer-top__subtitle"><?php echo sprintf(__('Inclusive of a %s discount', CTTHEME_LANG_TEXT), $block_data['price']['discount'] . '%') ?></p>
                <?php } ?>
            </div>

            <div class="card-villa__footer-bottom">
                <a class="card-villa__footer-bottom__main ct-btn-primary" data-btn-size="s" href="<?php echo get_site_url() . '/inquiry-form/?villa_id=' . $block_data['id'] . '&check_in=' . $check_in . '&check_out=' . $check_out . '&bedroom=' . $bedroom ?>"><?php _e('Inquire Now', CTTHEME_LANG_TEXT) ?></a>
                <button class="card-villa__footer-bottom__fav ct-icon" data-icon-pos="left">
                    <span><?php echo is_page_template('template-pages/wishlist.php') ? __('Remove from Wishlist', CTTHEME_LANG_TEXT) : __('In my wishlist', CTTHEME_LANG_TEXT) ?></span>
                </button>
            </div>
        </div>
    </div>

</div>