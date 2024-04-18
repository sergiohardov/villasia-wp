<div class="site-menu">
    <div class="ct-container">
        <div class="site-menu__inner">
            <div class="site-menu__destination site-menu-acc-first">
                <p class="site-menu__destination-title site-menu__title site-menu-acc-first__trigger"><?php _e('Destination', CTTHEME_LANG_TEXT) ?> <i class="ct-icon ct-icon--outline-plus"></i></p>

                <div class="site-menu__destination-primary site-menu-acc-first__panel">
                    <?php foreach ($args['countries'] as $country) { ?>
                        <?php $areas = get_terms([
                            'taxonomy' => CTCORE_TAXONOMY_AREA,
                            'hide_empty' => false,
                            'meta_query' => [
                                [
                                    'key' => 'country',
                                    'value' => $country->term_id,
                                    'compare' => '=',
                                ]
                            ],
                        ]); ?>
                        <div class="site-menu__destination-item site-menu-acc-second" data-country-link-id="<?php echo $country->term_id ?>">
                            <p class="site-menu__subtitle site-menu-acc-second__trigger"><?php echo $country->name ?> <i class="ct-icon ct-icon--outline-plus"></i></p>
                            <?php if ($areas) { ?>
                                <ul class="site-menu__primary site-menu-acc-second__panel">
                                    <?php foreach ($areas as $area) { ?>
                                        <li><a href="<?php echo get_term_link($area->term_id); ?>" data-area-link-id="<?php echo $area->term_id ?>"><?php echo $area->name ?></a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="site-menu__destination-secondary">
                    <?php foreach ($args['countries'] as $country) { ?>
                        <?php $areas = get_terms([
                            'taxonomy' => CTCORE_TAXONOMY_AREA,
                            'hide_empty' => false,
                            'meta_query' => [
                                [
                                    'key' => 'country',
                                    'value' => $country->term_id,
                                    'compare' => '=',
                                ]
                            ],
                        ]); ?>
                        <div class="site-menu__destination-secondary__item" data-country-list-id="<?php echo $country->term_id ?>">
                            <p class="site-menu__caption"><?php echo $country->name ?></p>
                            <?php foreach ($areas as $area) { ?>
                                <?php $cities = get_terms([
                                    'taxonomy' => CTCORE_TAXONOMY_CITY,
                                    'hide_empty' => false,
                                    'meta_query' => [
                                        [
                                            'key' => 'area',
                                            'value' => $area->term_id,
                                            'compare' => '=',
                                        ]
                                    ],
                                ]); ?>
                                <ul class="site-menu__secondary" data-area-list-id="<?php echo $area->term_id ?>">
                                    <?php if ($cities) { ?>
                                        <?php foreach ($cities as $city) {  ?>
                                            <li><a href="<?php echo get_term_link($city) ?>"><?php echo $city->name ?></a></li>
                                        <?php } ?>
                                    <?php } ?>

                                    <li><a href="<?php echo get_term_link($area) ?>"><?php _e('View All', CTTHEME_LANG_TEXT) ?></a></li>
                                </ul>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

            </div>

            <?php if ($args['themes']) { ?>
                <div class="site-menu__theme moved site-menu-acc-first">
                    <p class="site-menu__theme-title site-menu__title site-menu-acc-first__trigger">
                        <?php _e('Themes', CTTHEME_LANG_TEXT) ?>
                        <i class="ct-icon ct-icon--outline-plus"></i>
                        <i class="ct-icon ct-icon--outline-minus"></i>
                    </p>
                    <ul class="site-menu__theme-list site-menu-acc-first__panel">
                        <?php foreach ($args['themes'] as $theme) { ?>
                            <li><a href="<?php echo get_term_link($theme) ?>"><?php echo $theme->name ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <div class="site-menu__single">

                <?php if (has_nav_menu('header')) {
                    wp_nav_menu([
                        'theme_location'    => 'header',
                        'container'         => false,
                        'menu_class'        => 'site-menu__single-list',
                    ]);
                } ?>

                <div class="site-menu__single-btns">
                    <?php if ($args['primary_button']) { ?>
                        <a class="btn site-menu__single-btns__contact ct-btn-primary" data-btn-size="l" href="<?php echo $args['primary_button']['url'] ?>" target="<?php echo $args['primary_button']['target'] ?>"><?php echo $args['primary_button']['title']; ?></a>
                    <?php } ?>

                    <?php if ($args['secondary_button']) { ?>
                        <a class="site-menu__single-btns__submit ct-btn-secondary" data-btn-size="l" href="<?php echo $args['secondary_button']['url'] ?>" target="<?php echo $args['secondary_button']['target'] ?>">
                            <?php echo $args['secondary_button']['title']; ?>
                        </a>
                    <?php } ?>

                    <?php if ($args['social']) { ?>
                        <?php foreach ($args['social'] as $social) { ?>
                            <a class="site-menu__single-btns__social ct-btn-primary" data-btn-size="l" href="<?php echo $social['link'] ?>">
                                <?php echo wp_get_attachment_image($social['icon'], 'full');  ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>