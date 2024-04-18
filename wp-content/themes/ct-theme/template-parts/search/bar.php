<div class="search-bar">
    <form class="search-bar__form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="hidden" name="s">

        <div class="search-bar__main">
            <?php get_template_part('template-parts/interface/destination') ?>
            <?php get_template_part('template-parts/interface/check', null, ['adaptive' => 1]) ?>
            <?php get_template_part('template-parts/interface/bedroom') ?>
            <button class="search-bar__form-submit" type="submit"><?php _e('Search', CTTHEME_LANG_TEXT) ?></button>
        </div>

        <?php if (is_search() || is_archive()) { ?>
            <input id="searchInputOrder" type="hidden" name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : 'ASC' ?>">

            <?php $theme_data = get_terms([
                'taxonomy' => 'villa_theme',
                'hide_empty' => false
            ]);  ?>

            <?php $feature_data = [
                // TODO: Create dynamic price data 
                'rating' => [
                    [
                        'value' => 'all',
                        'label' => 'All'
                    ],
                    [
                        'value' => '3.5',
                        'label' => '3.5+'
                    ],
                    [
                        'value' => '4.0',
                        'label' => '4.0+'
                    ],
                    [
                        'value' => '4.5',
                        'label' => '4.5+'
                    ]
                ],
                'popular' => get_terms([
                    'taxonomy' => 'key_feature',
                    'hide_empty' => false
                ])
            ]; ?>

            <div class="search-bar__secondary">
                <div class="search-bar__secondary-price">
                    <?php $global_price_night = ct_core_get_villas_global_price_night_min(); ?>
                    <?php get_template_part('template-parts/interface/range', null, [
                        'min' => $global_price_night['min_price'],
                        'max' => $global_price_night['max_price'],
                        'from' => isset($_GET['price_from']) ? $_GET['price_from'] : $global_price_night['min_price'],
                        'to' => isset($_GET['price_to']) ? $_GET['price_to'] : $global_price_night['max_price'],
                    ]) ?>
                </div>
                <div class="search-bar__secondary-promotions">
                    <?php get_template_part('template-parts/interface/switcher', null, [
                        'title' => __('Display promotions only', CTTHEME_LANG_TEXT),
                        'value' => isset($_GET['promotions']) ? $_GET['promotions'] : 'off'
                    ]) ?>
                </div>
                <div class="search-bar__secondary-others">
                    <?php if ($theme_data) { ?>
                        <div class="search-bar__theme">
                            <label class="search-bar__secondary-label"><?php _e('Theme', CTTHEME_LANG_TEXT) ?></label>

                            <div class="search-bar__secondary-dropdown ct-dropdown">
                                <button class="search-bar__secondary-dropdown__toggle ct-dropdown__toggle" type="button" data-default-text="<?php _e('Select', CTTHEME_LANG_TEXT) ?>" data-alt-text="<?php _e('Themes', CTTHEME_LANG_TEXT) ?>"></button>

                                <div class="search-bar__secondary-dropdown__container ct-dropdown__menu">
                                    <div class="search-bar__secondary-dropdown__content">
                                        <div class="search-bar__theme-list">

                                            <?php foreach ($theme_data as $item) { ?>
                                                <label class="ct-checkbox">
                                                    <?php if (is_tax('villa_theme')) { ?>
                                                        <input class="search-bar__theme-input" type="checkbox" name="theme[]" value="<?php echo $item->term_id ?>" <?php echo get_queried_object()->term_id === $item->term_id ? 'checked' : ''; ?> />
                                                    <?php } else { ?>
                                                        <input class="search-bar__theme-input" type="checkbox" name="theme[]" value="<?php echo $item->term_id ?>" <?php echo isset($_GET['theme']) && in_array($item->term_id, $_GET['theme']) ? 'checked' : ''; ?> />
                                                    <?php } ?>
                                                    <span><?php echo $item->name ?></span>
                                                </label>
                                            <?php } ?>

                                        </div>
                                    </div>
                                    <div class="search-bar__secondary-dropdown__footer">
                                        <button class="search-bar__secondary-dropdown__reset" type="button"><?php _e('Reset all', CTTHEME_LANG_TEXT) ?></button>
                                        <button class="search-bar__secondary-dropdown__apply ct-btn-primary" data-btn-size="s" type="submit"><?php _e('Apply', CTTHEME_LANG_TEXT) ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($feature_data['rating'] || $feature_data['popular']) { ?>
                        <div class="search-bar__more">
                            <label class="search-bar__secondary-label"><?php _e('More filters', CTTHEME_LANG_TEXT) ?></label>
                            <div class="search-bar__secondary-dropdown ct-dropdown">
                                <button class="search-bar__secondary-dropdown__toggle ct-dropdown__toggle" type="button" data-default-text="<?php _e('Select', CTTHEME_LANG_TEXT) ?>" data-alt-text="<?php _e('Filters', CTTHEME_LANG_TEXT) ?>"></button>

                                <div class="search-bar__secondary-dropdown__container ct-dropdown__menu">
                                    <div class="search-bar__secondary-dropdown__content">

                                        <?php if ($feature_data['rating']) { ?>
                                            <div class="search-bar__more-rating-container">
                                                <p class="search-bar__secondary-dropdown__title"><?php _e('Guest rating', CTTHEME_LANG_TEXT) ?></p>
                                                <div class="search-bar__more-rating">
                                                    <?php foreach ($feature_data['rating'] as $item) { ?>
                                                        <label>
                                                            <input type="radio" name="rating" value="<?php echo $item['value'] ?>" <?php echo isset($_GET['rating']) && $_GET['rating'] === $item['value'] ? 'checked' : '' ?>>
                                                            <span><?php echo $item['label'] ?></span>
                                                        </label>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($feature_data['popular']) { ?>
                                            <div class="search-bar__more-popular-container">
                                                <p class="search-bar__secondary-dropdown__title"><?php _e('Popular filters', CTTHEME_LANG_TEXT) ?></p>
                                                <div class="search-bar__more-popular">
                                                    <?php foreach ($feature_data['popular'] as $item) { ?>
                                                        <label class="ct-checkbox">
                                                            <input class="search-bar__more-input" type="checkbox" name="feature[]" value="<?php echo $item->term_id ?>" <?php echo isset($_GET['feature']) && in_array($item->term_id, $_GET['feature']) ? 'checked' : ''; ?> />
                                                            <span><?php echo $item->name ?></span>
                                                        </label>
                                                    <?php } ?>
                                                </div>

                                                <button class="search-bar__more-show" type="button" data-default-text="<?php _e('View more', CTTHEME_LANG_TEXT) ?>" data-alt-text="<?php _e('View less', CTTHEME_LANG_TEXT) ?>">
                                                    <span><?php _e('View more', CTTHEME_LANG_TEXT) ?></span>
                                                    <i class="ct-icon ct-icon--outline-more"></i>
                                                </button>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <div class="search-bar__secondary-dropdown__footer">
                                        <button class="search-bar__secondary-dropdown__reset" type="button"><?php _e('Reset all', CTTHEME_LANG_TEXT) ?></button>
                                        <button class="search-bar__secondary-dropdown__apply ct-btn-primary" data-btn-size="s" type="submit"><?php _e('Apply', CTTHEME_LANG_TEXT) ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

            <div class="search-bar__mob">
                <button class="search-bar__mob-filters ct-icon ct-icon--outline-filter" data-icon-pos="left" type="button"><?php _e('Filters', CTTHEME_LANG_TEXT) ?></button>
                <button id="btnShowMobMap" class="search-bar__mob-map ct-icon ct-icon--fill-map" data-icon-pos="left" type="button"><?php _e('Show Map', CTTHEME_LANG_TEXT) ?></button>
            </div>

            <div class="search-bar__modal">
                <div class="search-bar__modal__header">
                    <button class="search-bar__modal__header-close" type="button">
                        <i class="ct-icon ct-icon--outline-close"></i>
                    </button>
                    <p class="search-bar__modal__header-title"><?php _e('Filters', CTTHEME_LANG_TEXT) ?></p>
                </div>
                <div class="search-bar__modal__content"></div>
                <div class="search-bar__modal__footer">
                    <button class="search-bar__modal__footer-reset" type="button"><?php _e('Reset all', CTTHEME_LANG_TEXT) ?></button>
                    <button class="search-bar__modal__footer-apply ct-btn-primary" data-btn-size="s" type="submit"><?php _e('Apply', CTTHEME_LANG_TEXT) ?></button>
                </div>
            </div>
        <?php } ?>

    </form>
</div>