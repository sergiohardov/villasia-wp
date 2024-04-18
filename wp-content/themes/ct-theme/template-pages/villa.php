<?php global $wishlist_ids; ?>

<div class="page-villa" data-villa-id="<?php the_ID() ?>" data-in-wishlist="<?php echo in_array(get_the_ID(),  $wishlist_ids) ? '1' : '0' ?>">

    <?php get_template_part('template-parts/site/breadcrumbs') ?>

    <?php get_template_part('template-parts/villa/gallery', null, [
        'images' => get_field('photos_group'),
        'title' => get_the_title(),
    ]) ?>

    <?php get_template_part('template-parts/villa/navigation') ?>

    <section class="page-villa-content">
        <div class="ct-container">
            <div class="page-villa-content__inner">
                <div class="page-villa-content__main">

                    <?php get_template_part('template-parts/villa/overview', null, [
                        'title' => get_the_title(),
                        'best_choice' => ct_core_villa_is_best_choice(get_the_ID()),
                        'rate' => get_field(CTCORE_FIELD_VILLA_RATING),
                        'location' => get_term(get_field('main_group_city'))->name . ', ' . get_term(get_field('main_group_area'))->name,
                        'guests' => get_field('main_group_guests'),
                        'bedrooms' => get_field('main_group_bedrooms'),
                        'bathrooms' => get_field('main_group_bathrooms'),
                        'desc' => get_field('text_group_description'),
                    ]); ?>

                    <?php get_template_part('template-parts/villa/keyfeature', null, [
                        'features' => get_field('themes_features_group_key_features')
                    ]) ?>

                    <?php get_template_part('template-parts/villa/rental', null, [
                        'included' => get_field('rental_notes_group_included'),
                        'extra' => get_field('rental_notes_group_extra')
                    ]) ?>

                    <?php get_template_part('template-parts/villa/bedrooms', null, [
                        'bedrooms' => get_field('bedrooms_group'),
                        'capacity' => get_field('capacity_group_capacity')
                    ]) ?>

                    <?php
                    $conditions_sync = get_field(CTCORE_FIELD_VILLA_CONDITIONS_SYNC);
                    $conditions = [];

                    if ($conditions_sync === 'yes') {
                        $owner_id = get_field(CTCORE_FIELD_VILLA_OWNER_ID);
                        $area_id = get_field(CTCORE_FIELD_VILLA_AREA_ID);

                        $owner_conditions = get_field(CTCORE_FIELD_OWNER_CONDITIONS, $owner_id);

                        $conditions = isset($owner_conditions[$area_id]) ? $owner_conditions[$area_id] : [];
                    } else {
                        $conditions = get_field(CTCORE_FIELD_VILLA_CONDITIONS_DATA);
                    }

                    get_template_part('template-parts/villa/rates', null, [
                        'sync' => get_field(CTCORE_FIELD_VILLA_RATE_SYNC),
                        'rate_id' => get_field(CTCORE_FIELD_VILLA_RATE_ID),
                        'price' => get_field(CTCORE_FIELD_VILLA_PRICE),
                        'tax' => [
                            'tax_service' => get_field(CTCORE_FIELD_VILLA_TAX_SERVICE),
                            'tax_rate' => get_field(CTCORE_FIELD_VILLA_TAX_RATE),
                        ],
                        'conditions' => $conditions
                    ])
                    ?>

                    <?php get_template_part('template-parts/villa/reviews', null, [
                        'rating' => get_field(CTCORE_FIELD_VILLA_RATING),
                        'reviews' => get_field(CTCORE_FIELD_VILLA_REVIEWS)
                    ]) ?>

                    <?php get_template_part('template-parts/villa/location', null, [
                        'location' => get_field('main_group_map'),
                        'desc' => get_field('text_group_around')
                    ]) ?>
                </div>

                <div id="villaPageSidebarBlock" class="page-villa-content__sidebar">
                    <button id="villaPageSidebarClose" class="page-villa-content__sidebar-close"><i class="ct-icon ct-icon--outline-close"></i></button>
                    <?php get_template_part('template-parts/card/booking') ?>
                </div>

                <div id="villaPageSidebarToggle" class="page-villa-content__mob">
                    <button class="page-villa-content__mob-btn"><?php _e('Check Availability', CTTHEME_LANG_TEXT) ?></button>
                </div>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/villa/related', null, [
        'current_id' => get_the_ID(),
        'type_related' => get_field('related_type_of_related') ?: 'auto',
        'area_id' => get_field(CTCORE_FIELD_VILLA_AREA_ID),
        'manual_villas' => get_field('related_manual_villas') ?: [],
    ]) ?>
</div>