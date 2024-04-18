<?php
global $wp_query;

$check_in = isset($_GET['check_in']) ? $_GET['check_in'] : null;
$check_out = isset($_GET['check_out']) ? $_GET['check_out'] : null;
$bedroom = isset($_GET['bedroom']) ? $_GET['bedroom'] : 0;
?>

<div class="page-general">
    <?php get_template_part('template-parts/site/breadcrumbs') ?>

    <div class="page-general__search">
        <div class="ct-container">
            <?php get_template_part('template-parts/search/bar') ?>
        </div>
    </div>

    <div class="ct-container">
        <div id="mainContainer" class="page-general__content">
            <div class="page-general__main">
                <div class="page-general__header">
                    <span class="page-general__header-count"><?php echo $wp_query->post_count ?> Vacation rentals in <?php echo isset($_GET['destination']) && !empty($_GET['destination']) ? ct_theme_get_format_location($_GET['destination']) : __('All', CTTHEME_LANG_TEXT) ?></span>

                    <div class="page-general__header-controlls">
                        <select id="generalOrderSelect" class="page-general__header-sort ct-select">
                            <option value="ASC" <?php echo isset($_GET['order']) && $_GET['order'] === 'ASC' ? 'selected' : '' ?>><?php _e('Price low to high', CTTHEME_LANG_TEXT) ?></option>
                            <option value="DESC" <?php echo isset($_GET['order']) && $_GET['order'] === 'DESC' ? 'selected' : '' ?>><?php _e('Price high to low', CTTHEME_LANG_TEXT) ?></option>
                        </select>
                        <button id="btnShowDeskMap" class="page-general__header-map ct-btn-primary ct-icon ct-icon--fill-map" data-btn-size="s" data-icon-pos="left"><?php _e('Show map', CTTHEME_LANG_TEXT) ?></button>
                    </div>
                </div>
                <div class="page-general__results">
                    <?php if (have_posts()) { ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php $villa_data = [
                                'link' => get_the_permalink() . '?check_in=' . $check_in . '&check_out=' . $check_out . '&bedroom=' . $bedroom,
                            ]; ?>

                            <div class="page-general__item">
                                <?php get_template_part('template-parts/card/villa', null, $villa_data); ?>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php } ?>
                </div>
                <div class="page-general__pagination">
                    <?php echo paginate_links([
                        'prev_text' => '<i class="ct-icon ct-icon--outline-next"></i>',
                        'next_text' => '<i class="ct-icon ct-icon--outline-next"></i>',
                    ]) ?>
                </div>
            </div>

            <div class="page-general__map">
                <button id="btnCloseMap" class="page-general__map-close">
                    <i class="ct-icon ct-icon--outline-close"></i>
                </button>

                <?php get_template_part('template-parts/villas-map') ?>
            </div>
        </div>
    </div>
</div>