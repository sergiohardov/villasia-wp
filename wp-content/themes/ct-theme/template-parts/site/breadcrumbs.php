<section class="site-breadcrumbs">
    <div class="ct-container">
        <div class="site-breadcrumbs__inner">
            <?php if (is_single() && get_post_type() === CTCORE_POST_TYPE_VILLA) { ?>

                <?php $breadcrumb_items = [
                    'country' => get_term(get_field(CTCORE_FIELD_VILLA_COUNTRY_ID), CTCORE_TAXONOMY_COUNTRY),
                    'area' => get_term(get_field(CTCORE_FIELD_VILLA_AREA_ID), CTCORE_TAXONOMY_AREA),
                    'city' => get_term(get_field(CTCORE_FIELD_VILLA_CITY_ID), CTCORE_TAXONOMY_CITY),
                ]; ?>

                <span class="site-breadcrumbs--desk">
                    <span>
                        <a href="<?php echo get_site_url() ?>"><?php _e('Home', CTTHEME_LANG_TEXT) ?></a>
                    </span>
                    <i class="ct-icon ct-icon--outline-next"></i>

                    <?php foreach ($breadcrumb_items as $item) { ?>
                        <?php if ($item) { ?>
                            <span>
                                <a href="<?php echo get_term_link($item); ?>"><?php echo $item->name ?></a>
                            </span>
                            <i class="ct-icon ct-icon--outline-next"></i>
                        <?php } ?>
                    <?php } ?>

                    <span class="breadcrumb_last" aria-current="page"><?php the_title() ?></span>
                </span>

                <span class="site-breadcrumbs--mob">
                    <i class="ct-icon ct-icon--outline-next"></i>
                    <span>
                        <a href="<?php echo $breadcrumb_items['city'] ? get_term_link($breadcrumb_items['city']) : get_site_url() ?>"><?php echo $breadcrumb_items['city'] ? __('See all villas in', CTTHEME_LANG_TEXT) . ' ' . $breadcrumb_items['city']->name : __('Home', CTTHEME_LANG_TEXT) ?> </a>
                    </span>
                </span>
            <?php  } elseif ((is_tax(CTCORE_TAXONOMY_COUNTRY) || is_tax(CTCORE_TAXONOMY_AREA) || is_tax(CTCORE_TAXONOMY_CITY)) && get_post_type() === CTCORE_POST_TYPE_VILLA) { ?>

                <?php if (is_tax(CTCORE_TAXONOMY_COUNTRY)) {
                    $breadcrumb_items = [
                        get_term(get_field(CTCORE_FIELD_VILLA_COUNTRY_ID), CTCORE_TAXONOMY_COUNTRY),
                    ];
                } elseif (is_tax(CTCORE_TAXONOMY_AREA)) {
                    $breadcrumb_items = [
                        get_term(get_field(CTCORE_FIELD_VILLA_COUNTRY_ID), CTCORE_TAXONOMY_COUNTRY),
                        get_term(get_field(CTCORE_FIELD_VILLA_AREA_ID), CTCORE_TAXONOMY_AREA),
                    ];
                } elseif (is_tax(CTCORE_TAXONOMY_CITY)) {
                    $breadcrumb_items = [
                        get_term(get_field(CTCORE_FIELD_VILLA_COUNTRY_ID), CTCORE_TAXONOMY_COUNTRY),
                        get_term(get_field(CTCORE_FIELD_VILLA_AREA_ID), CTCORE_TAXONOMY_AREA),
                        get_term(get_field(CTCORE_FIELD_VILLA_CITY_ID), CTCORE_TAXONOMY_CITY),
                    ];
                } ?>

                <span>
                    <span>
                        <a href="<?php echo get_site_url() ?>"><?php _e('Home', CTTHEME_LANG_TEXT) ?></a>
                    </span>
                    <i class="ct-icon ct-icon--outline-next"></i>

                    <?php $i = 0 ?>
                    <?php foreach ($breadcrumb_items as $item) { ?>
                        <?php if ($item) { ?>
                            <?php if ($i !== count($breadcrumb_items) - 1) { ?>
                                <span>
                                    <a href="<?php echo get_term_link($item); ?>"><?php echo $item->name ?></a>
                                </span>
                                <i class="ct-icon ct-icon--outline-next"></i>
                            <?php } else { ?>
                                <span class="breadcrumb_last" aria-current="page"><?php echo $item->name ?></span>
                            <?php } ?>
                        <?php } ?>
                        <?php $i++ ?>
                    <?php } ?>
                </span>

            <?php } else { ?>
                <?php echo do_shortcode('[wpseo_breadcrumb]') ?>
            <?php } ?>
        </div>
    </div>
</section>