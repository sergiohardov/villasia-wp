<?php
/* 
    Template Name: Thankyou
*/
?>

<?php get_header(); ?>

<div class="page-thankyou">
    <div class="page-thankyou__hero">
        <div class="page-thankyou__hero-bg">
            <?php echo wp_get_attachment_image(get_field('hero')['background'], 'full') ?>
        </div>

        <div class="page-thankyou__hero-content">
            <div class="ct-container">
                <div class="page-thankyou__hero-inner">
                    <h1 class="page-thankyou__hero-title"> <?php echo get_field('hero')['title'] ?></h1>
                    <div class="page-thankyou__hero-desc">
                        <?php echo get_field('hero')['description'] ?>
                    </div>
                    <a class="page-thankyou__hero-link ct-btn-primary" data-btn-size="l" href="<?php echo home_url() ?>"><?php _e('Go to the main page', CTTHEME_LANG_TEXT) ?></a>
                </div>
            </div>
        </div>

    </div>

    <?php get_template_part('template-parts/slider-locations', null, [
        'title' => get_field('slider_locations')['title'],
        'content' => get_field('slider_locations')['content'],
    ]) ?>

    <div class="page-thankyou__search">
        <div class="ct-container">
            <?php get_template_part('template-parts/search/bar') ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>