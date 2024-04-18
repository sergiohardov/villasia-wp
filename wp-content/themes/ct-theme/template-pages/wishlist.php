<?php
/* 
    Template Name: Wishlist
*/
?>
<?php get_header(); ?>

<?php global $wishlist_query; ?>

<div class="page-wishlist">
    <div class="ct-container">
        <div id="mainContainer" class="page-wishlist__content">
            <div class="page-wishlist__main">
                <div class="page-wishlist__header">
                    <h1 class="page-wishlist__title"><?php the_title() ?></h1>

                    <div class="page-wishlist__controlls">
                        <select id="generalOrderSelect" class="page-wishlist__controlls-sort ct-select">
                            <option value="ASC" <?php echo isset($_GET['order']) && $_GET['order'] === 'ASC' ? 'selected' : '' ?>><?php _e('Price low to high', CTTHEME_LANG_TEXT) ?></option>
                            <option value="DESC" <?php echo isset($_GET['order']) && $_GET['order'] === 'DESC' ? 'selected' : '' ?>><?php _e('Price high to low', CTTHEME_LANG_TEXT) ?></option>
                        </select>
                        <button id="btnShowMap" class="page-wishlist__controlls-map ct-btn-primary ct-icon ct-icon--fill-map" data-btn-size="s" data-icon-pos="left"><?php _e('Show map', CTTHEME_LANG_TEXT) ?></button>
                    </div>
                </div>
                <?php if ($wishlist_query->have_posts()) { ?>
                    <div class="page-wishlist__list">
                        <?php while ($wishlist_query->have_posts()) {
                            $wishlist_query->the_post();
                            get_template_part('template-parts/card/villa');
                        }
                        wp_reset_postdata() ?>
                    </div>
                <?php } else { ?>
                    <h3 class="ct-text-center"><?php _e('Your wishlist empty.', CTTHEME_LANG_TEXT) ?></h3>
                <?php } ?>
            </div>
            <div class="page-wishlist__map">
                <button id="btnCloseMap" class="page-wishlist__map-close">
                    <i class="ct-icon ct-icon--outline-close"></i>
                </button>

                <?php get_template_part('template-parts/villas-map') ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>